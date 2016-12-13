<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Member extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
            define('THEME', $row->themes_config);
        }
        if (!$this->session->userdata('fronlang_iso')) {
            $this->Csz_model->setSiteLang();
        }
        if ($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0) {
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang();
        }
        $this->_init();
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        $title = 'Member | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $pageURL);
    }

    public function index() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('member');
        $this->template->setSub('users', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
        $this->template->loadSub('frontpage/member/home');
    }

    public function login() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        //Load the form helper

        $this->template->setSub('config', $this->Csz_model->load_config());
        $this->template->setSub('error', '');
        $this->load->helper('form');
        $this->template->loadSub('frontpage/member/login');
    }

    public function loginCheck() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $email = $this->Csz_model->cleanEmailFormat($this->input->post('email', TRUE));
        $password = sha1(md5($this->input->post('password', TRUE)));
        $result = $this->Csz_model->memberLogin($email, $password);
        if ($result == 'SUCCESS') {
            $this->Csz_model->saveLogs($email, 'Member Login Successful!', $result);
            $url_return = $this->input->post('url_return', TRUE);
            if($url_return){
                redirect($url_return, 'refresh');
            }else{
                redirect(BASE_URL.'/member', 'refresh');
            }
        } else {
            $this->Csz_model->saveLogs($email, 'Member Login Invalid!', $result);
            $this->template->setSub('error', $result);
            $this->load->helper('form');
            $this->template->loadSub('frontpage/member/login');
        }
    }

    public function logout() {
        $data = array(
            'user_admin_id',
            'admin_name',
            'admin_email',
            'admin_type',
            'admin_visitor',
            'session_id',
            'admin_logged_in',
        );
        $this->session->unset_userdata($data);
        redirect(BASE_URL.'/member', 'refresh');
    }

    public function registMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $config = $this->Csz_model->load_config();
        if($config->member_close_regist){
            $this->session->set_flashdata('f_error_message','<div class="alert alert-danger" role="alert">Sorry!!! Member register is closed!</div>');
            redirect(BASE_URL.'/member', 'refresh');
            exit();
        }else{
            //Load the form helper
            $this->load->helper('form');
            //Load the view
            $this->template->setSub('chksts', 0);
            $this->template->loadSub('frontpage/member/regist');
        }
    }

    public function saveMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $config = $this->Csz_model->load_config();
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email|is_unique[user_admin.email]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', 'confirm password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->template->setSub('chksts', 0);
            $this->form_validation->set_message('email', $this->Csz_model->getLabelLang('email_already'));
            $this->template->loadSub('frontpage/member/regist');
        } else if ($this->Csz_model->chkCaptchaRes() == '') {
            $this->template->setSub('chksts', 0);
            $this->template->loadSub('frontpage/member/regist');
        } else {
            $email = $this->Csz_model->cleanEmailFormat($this->input->post('email', TRUE));
            $md5_hash = $this->Csz_model->createMember();
            if($md5_hash !== FALSE){
                if($config->member_confirm_enable){
                    /* now we will send an email */
                    # ---- set subject --#
                    $subject = $this->Csz_model->getLabelLang('email_confirm_subject');
                    # ---- set from, to, bcc --#
                    $from_name = $config->site_name;
                    $from_email = 'no-reply@' . EMAIL_DOMAIN;
                    $to_email = $email;
                    $message_html = $this->Csz_model->getLabelLang('email_dear') . $email . ',<br><br>' . $this->Csz_model->getLabelLang('email_confirm_message') . '<br><a href="' . BASE_URL . '/member/confirm/' . $md5_hash . '" target="_blank"><b>' . BASE_URL . '/member/confirm/' . $md5_hash . '</b></a> <br> <br>' . $this->Csz_model->getLabelLang('email_footer') . '<br><a href="' . BASE_URL . '" target="_blank"><b>' . $config->site_name . '</b></a>';
                    @$this->Csz_model->sendEmail($to_email, $subject, $message_html, $from_email, $from_name);
                    $this->template->setSub('chksts', 1);
                    $this->template->loadSub('frontpage/member/regist');
                }else{
                    redirect(BASE_URL . '/member/confirm/' . $md5_hash, 'refresh');
                    exit();
                }
            }else{
                $this->session->set_flashdata('f_error_message','<div class="alert alert-danger" role="alert">Sorry!!! Member register is closed!</div>');
                redirect('member', 'refresh');
                exit();
            }
        }
    }

    public function confirmedMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $md5_hash = $this->uri->segment(3);
        $user_rs = $this->Csz_model->getValue('*', 'user_admin', 'md5_hash', $md5_hash, 1);
        if (!$user_rs) {
            $this->session->set_flashdata('f_error_message','<div class="alert alert-danger" role="alert">Sorry!!! Invalid Request!</div>');
        } else {
            $data = array(
                'active' => 1,
                'md5_hash' => md5(time() + mt_rand(1, 99999999)),
            );
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->where('user_type', 'member');
            $this->db->where('md5_hash', $md5_hash);
            $this->db->where('user_admin_id', $user_rs->user_admin_id);
            $this->db->update('user_admin', $data);
            $this->session->set_flashdata('f_error_message','<div class="alert alert-success" role="alert">Success!</div>');
        }
        redirect('member', 'refresh');
    }

    public function editMember() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if ($this->session->userdata('user_admin_id')) {
            //Get user details from database
            $this->template->setSub('users', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
            //Load the view
            $this->template->loadSub('frontpage/member/edit');
        }
    }

    public function saveEditMember() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        Member_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[user_admin.email.user_admin_id.' . $this->session->userdata('user_admin_id') . ']');
        $this->form_validation->set_rules('password', 'New Password', 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');
        $this->form_validation->set_rules('cur_password', 'Current Password', 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_message('cur_password', $this->Csz_model->getLabelLang('login_incorrect'));
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editMember();
        } else {
            //Validation passed
            //Update the user
            $rs = $this->Csz_model->updateMember($this->session->userdata('user_admin_id'));
            if($rs !== FALSE){
                //Return to user list
                redirect('member', 'refresh');
            }else{
                $this->load->helper('form');
                if ($this->session->userdata('user_admin_id')) {
                    //Get user details from database
                    $this->template->setSub('users', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
                    //Load the view
                    $this->session->set_flashdata('f_error_message','<div class="alert alert-danger" role="alert">'.$this->Csz_model->getLabelLang('login_incorrect').'</div>');
                    $this->template->loadSub('frontpage/member/edit');
                }
            }
            
        }
    }

    /*     * ************ Forgotten Password Resets ************* */

    public function forgot() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $row = $this->Csz_model->load_config();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        if ($this->form_validation->run() == FALSE) {
            $this->template->setSub('chksts', 0);
            $this->template->setSub('error_chk', 0);
            $this->template->loadSub('frontpage/member/email_forgot');
        } else if ($this->Csz_model->chkCaptchaRes() == '') {
            $this->template->setSub('chksts', 0);
            $this->template->setSub('error_chk', 1);
            $this->template->loadSub('frontpage/member/email_forgot');
        } else {
            $email = $this->Csz_model->cleanEmailFormat($this->input->post('email', TRUE));
            $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->where('email', $email);
            $this->db->update('user_admin');
            $this->load->helper('string');
            $user_rs = $this->Csz_model->getValue('md5_hash', 'user_admin', 'email', $email, 1);
            $md5_hash = $user_rs->md5_hash;

            //now we will send an email
            # ---- set subject --#
            $subject = $this->Csz_model->getLabelLang('email_reset_subject');
            # ---- set from, to, bcc --#
            $from_name = $row->site_name;
            $from_email = 'no-reply@' . EMAIL_DOMAIN;
            $to_email = $email;
            $message_html = $this->Csz_model->getLabelLang('email_dear') . $email . ',<br><br>' . $this->Csz_model->getLabelLang('email_reset_message') . '<br><a href="' . BASE_URL . '/member/reset/' . $md5_hash . '" target="_blank"><b>' . BASE_URL . '/member/reset/' . $md5_hash . '</b></a><br><br>' . $this->Csz_model->getLabelLang('email_footer') . '<br><a href="' . BASE_URL . '" target="_blank"><b>' . $row->site_name . '</b></a>';
            @$this->Csz_model->sendEmail($to_email, $subject, $message_html, $from_email, $from_name);
            $this->template->setSub('error_chk', 0);
            $this->template->setSub('chksts', 1);
            $this->template->loadSub('frontpage/member/email_forgot');
        }
    }

    public function email_check($str) {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $this->db->where('email', $str);
        $this->db->limit(1, 0);
        $query = $this->db->get('user_admin');
        if ($query->num_rows() == 1) {
            return true;
        } else {
            $this->form_validation->set_message('email_check', $this->Csz_model->getLabelLang('email_check'));
            return false;
        }
    }

    public function getPassword() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $md5_hash = $this->uri->segment(3);
        $this->Csz_admin_model->chkMd5Time($md5_hash);
        $user_rs = $this->Csz_model->getValue('*', 'user_admin', 'md5_hash', $md5_hash, 1);
        if (!$user_rs) {
            redirect('member/forgot', 'refresh');
        } else {
            $this->template->setSub('email', $user_rs->email);
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]|matches[con_password]');
            $this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->template->setSub('success_chk', 0);
                $this->template->loadSub('frontpage/member/resetform');
            } else {
                if (!$user_rs->email) {
                    show_error('Sorry!!! Invalid Request!');
                } else {
                    $data = array(
                        'password' => sha1(md5($this->input->post('password', TRUE))),
                        'md5_hash' => md5(time() + mt_rand(1, 99999999)),
                    );
                    $this->db->set('md5_lasttime', 'NOW()', FALSE);
                    $this->db->where('md5_hash', $md5_hash);
                    $this->db->update('user_admin', $data);
                    
                    $this->template->setSub('success_chk', 1);
                    $this->template->loadSub('frontpage/member/resetform');
                }
            }
        }
    }

}
