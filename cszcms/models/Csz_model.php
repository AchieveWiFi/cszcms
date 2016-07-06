<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getVersion($xml_url = '') {
        if (!$xml_url) { 
            $xml_file = BASE_URL . '/version.xml';
        }
        $xml = simplexml_load_file($xml_file) or die("Error: Cannot create object");
        if ($xml->version) {
            if ($xml->release == 'beta') {
                $beta = ' Beta';
            } else {
                $beta = '';
            }
            return $xml->version . $beta;
        } else {
            return FALSE;
        }
    }

    public function downloadFile($url, $path) {
        $newfname = $path;
        $file = fopen ($url, 'rb');
        if ($file) {
            $newf = fopen ($newfname, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 1024 * 10), 1024 * 1024 * 10); /* 10MB */
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
    }

    public function countData($table, $search_sql = '', $groupby = '', $orderby = 'timestamp_create', $sort = 'desc') {
        $this->db->select('*');
        if($search_sql){
            if(is_array($search_sql)){
                /* $search = array('field'=>'value') */
                foreach ($search_sql as $key => $value) {
                    $this->db->where($key, $value);
                }
            }else{
                /* $search = "name='Joe' AND status LIKE '%boss%' OR status1 LIKE '%active%'")*/
                $this->db->where($search_sql);
            }
        }
        if($groupby) $this->db->group_by($groupby);
        $this->db->order_by($orderby, $sort);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function getCurPages() {
        $totSegments = $this->uri->total_segments();
        if (!is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments);
        } else if (is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments - 1);
        }
        if ($pageURL == "") {
            $defaultpage = $this->getDefualtPage($this->session->userdata('fronlang_iso'));
            if($defaultpage !== FALSE){
                $pageURL = $defaultpage;
            }else{
                $pageURL = $this->getDefualtPage($this->getDefualtLang());
            }
        }
        return $pageURL;
    }

    public function getValue($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '') {
        $this->db->select($sel_field);
        if (is_array($where_field) && is_array($where_val)) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_val[$i]);
            }
        } else {
            $this->db->where($where_field, $where_val);
        }
        if ($orderby && $sort) {
            $this->db->order_by($orderby, $sort);
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            if ($query->num_rows() == 1) {
                $row = $query->row();
            } else if ($query->num_rows() > 1) {
                $row = $query->result();
            }
            return $row;
        } else {
            return FALSE;
        }
    }
    
    public function getValueArray($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '') {
        $this->db->select($sel_field);
        if (is_array($where_field) && is_array($where_val)) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_val[$i]);
            }
        } else {
            $this->db->where($where_field, $where_val);
        }
        if ($orderby && $sort) {
            $this->db->order_by($orderby, $sort);
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function load_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    function getLang() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->admin_lang;
        }
    }

    public function getCountryCode($lang) {
        $this->db->limit(1, 0);
        $this->db->where("lang_iso", $lang);
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->country_iso;
        }
    }

    public function getPageUrlFromID($id) {
        $this->db->limit(1, 0);
        $this->db->where("pages_id", $id);
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->page_url;
        }
    }

    public function getDefualtPage($lang) {
        $this->db->where("lang_iso", $lang);
        $this->db->limit(1, 0);
        $this->db->order_by('pages_id ASC');
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->page_url;
        }else{
            return FALSE;
        }
    }

    public function getDefualtLang() {
        $this->db->limit(1, 0);
        $this->db->where("lang_iso_id", 1);
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->lang_iso;
        }
    }

    public function chkLangAlive($lang_iso) {
        $this->db->where("lang_iso", $lang_iso);
        $this->db->where("active", 1);
        $query = $this->db->get('lang_iso');
        return $query->num_rows();
    }

    public function setSiteLang($lang_iso = '') {
        if (!$lang_iso) {
            $set_lang_iso = $this->getDefualtLang();
        } else {
            if ($this->chkLangAlive($lang_iso) > 0) {
                $set_lang_iso = $lang_iso;
            } else {
                $set_lang_iso = $this->getDefualtLang();
            }
        }
        $this->session->set_userdata('fronlang_iso', $set_lang_iso);
    }

    public function loadAllLang($active = 0) {
        $this->db->select("*");
        if ($active)
            $this->db->where("active", 1);
        $this->db->order_by("lang_iso_id", "asc");
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function load_page($pageurl) {
        $this->db->where("page_url", $pageurl);
        $this->db->where("active", 1);
        $this->db->limit(1, 0);
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function main_menu($drop_page_menu_id = 0, $lang) {
        if ($drop_page_menu_id) {
            $this->db->where("drop_page_menu_id", $drop_page_menu_id);
        } else {
            $this->db->where("drop_page_menu_id", 0);
        }
        $this->db->where("lang_iso", $lang);
        $this->db->where("active", 1);
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('page_menu');
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function getSocial() {
        $this->db->select("*");
        $this->db->where("active", 1);
        $this->db->order_by("social_name", "asc");
        $query = $this->db->get('footer_social');
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function cszCopyright() {
        $row = $this->Csz_model->load_config();
        $html = '<span class="copyright">'.$row->site_footer.'</span>
                <small style="color:gray;">'.$this->Csz_admin_model->cszCopyright().'</small>';
        return $html;
    }

    public function coreCss() {
        $core_css = link_tag('assets/css/bootstrap.min.css');
        $core_css.= link_tag('assets/font-awesome/css/font-awesome.min.css');
        $core_css.= link_tag('assets/css/flag-icon.min.css');
        $core_css.= link_tag('assets/css/full-slider.css');
        return $core_css;
    }

    public function coreJs() {
        if($this->session->userdata('fronlang_iso')){
            $hl = '?hl='.$this->session->userdata('fronlang_iso');
        }else{
            $hl = '';
        }
        $core_js = '<script src="' . base_url() . 'assets/js/jquery-1.10.2.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/bootstrap.min.js"></script>';
        $core_js.= '<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/scripts.js"></script>';
        $core_js.= '<script src="https://www.google.com/recaptcha/api.js'.$hl.'"></script>';
        return $core_js;
    }

    public function coreMetatags($desc_txt, $keywords) {
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => $desc_txt),
            array('name' => 'keywords', 'content' => $keywords),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
            array('name' => 'author', 'content' => $this->load_config()->site_name),
            array('name' => 'designer', 'content' => 'Powered by CSZ-CMS'),
            array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $return_meta = meta($meta);
        return $return_meta;
    }

    public function rw_link($val) {
        $val = strip_tags($val);
        $val = strtolower($val);
        $val = trim($val);
        $val = trim($val);
        $val = trim($val);
        $val = str_replace('&amp', 'and', $val);
        $val = str_replace('–', '-', $val);
        $val = str_replace(' ', '-', $val);
        $val = str_replace("'s-", '-', $val);
        $val = str_replace("’s-", '-', $val);
        $val = str_replace('!', '-', $val);
        $val = str_replace('@', '-', $val);
        $val = str_replace('#', '-', $val);
        $val = str_replace('$', '-', $val);
        $val = str_replace('%', '-', $val);
        $val = str_replace('^', '-', $val);
        $val = str_replace('&', '-', $val);
        $val = str_replace('*', '-', $val);
        $val = str_replace('(', '-', $val);
        $val = str_replace(')', '-', $val);
        $val = str_replace('_', '-', $val);
        $val = str_replace('+', '-', $val);
        $val = str_replace('|', '-', $val);
        $val = str_replace('{', '-', $val);
        $val = str_replace('}', '-', $val);
        $val = str_replace(':', '-', $val);
        $val = str_replace('"', '', $val);
        $val = str_replace('‘', '', $val);
        $val = str_replace('’', '', $val);
        $val = str_replace('<', '-', $val);
        $val = str_replace('>', '-', $val);
        $val = str_replace('?', '-', $val);
        $val = str_replace('/', '-', $val);
        $val = str_replace('.', '-', $val);
        $val = str_replace(',', '-', $val);
        $val = str_replace("'", '', $val);
        $val = str_replace(';', '-', $val);
        $val = str_replace(']', '-', $val);
        $val = str_replace('[', '-', $val);
        $val = str_replace('=', '-', $val);
        $val = str_replace('----', '-', $val);
        $val = str_replace('---', '-', $val);
        $val = str_replace('--', '-', $val);
        $val = str_replace('--', '-', $val);
        return $val;
    }
    
    public function getHtmlContent($ori_content, $page, $url_segment) { /* Calculate the HTML code */
        $config = $this->load_config();
        if($config->link_statistic_active){
            $ori_content = $this->linkFromHtml($ori_content);
        }
        $ori_content = $this->frmNameInHtml($ori_content, $page, $url_segment);
        return $ori_content;
    }
    
    public function linkFromHtml($content) { /* Find and replace a tag in content */
        if (strpos($content, ' href="') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $content);
            $array = explode("<a ", $txt_nonline);
            foreach ($array as $key => $value) {
                $link[] = $array[$key];
            }
            foreach ($link as $val) {
                if(preg_match('/href=/', $val) && !preg_match('/href="#/', $val)) {
                    list($Gone,$Keep) = explode("href=\"", trim($val));
                    list($Keep,$Gone) = explode("\"", $Keep);
                    $content = strtr($content, array("$Keep" => BASE_URL."/linkstats?url=$Keep"));
                }
            }
        }
        return $content;
    }

    public function frmNameInHtml($content, $page, $url_segment) { /* Find the form in content */
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=forms:') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            foreach ($array as $key => $value) {
                $form_name[] = $array[$key];
            }            
            foreach ($form_name as $val) {
                if (strpos($val, '{=forms:') !== false) {
                    $rep_arr = array('{=forms:', '}');
                    $frm_name = str_replace($rep_arr, '', $val);
                    $content = $this->addFrmToHtml($content, $frm_name, $page, $url_segment);
                    break;
                }  
            }
        }
        return $content;
    }

    public function addFrmToHtml($content, $frm_name, $cur_page = '', $status = '') { /* Add the form in content */
        $row_config = $this->load_config();
        $where_arr = array('form_name', 'active');
        $val_arr = array($frm_name, 1);
        $form_data = $this->getValue('*', 'form_main', $where_arr, $val_arr, 1);
        if ($form_data) {
            $html_btn = '';
            if ($status == 1) {
                $sts_msg = '<p class="text-center"><span class="success">' . $form_data->success_txt . '</span><br></p>';
            } else if ($status == 2) {
                $sts_msg = '<p class="text-center"><span class="error">' . $form_data->captchaerror_txt . '</span><br></p>';
            } else if ($status == 3) {
                $sts_msg = '<p class="text-center"><span class="error">' . $form_data->error_txt . '</span><br></p>';
            } else {
                $sts_msg = '';
            }
            $html = $sts_msg;
            $html.= '<form action="' . BASE_URL . '/formsaction/' . $form_data->form_main_id . '" name="' . $frm_name . '" method="' . $form_data->form_method . '" enctype="' . $form_data->form_enctype . '" accept-charset="utf-8">';
            $html.= '<input type="hidden" name="cur_page" id="cur_page" value="' . $cur_page . '">';
            $field_data = $this->getValue('*', 'form_field', 'form_main_id', $form_data->form_main_id, '', 'form_field_id', 'asc');
            foreach ($field_data as $field) {
                if ($field->field_required) {
                    $f_req = ' required="required" autofocus="true"';
                    $star_req = ' <i style="color:red;">*</i>';
                } else {
                    $f_req = '';
                    $star_req = '';
                }
                if ($field->field_type == 'checkbox' || $field->field_type == 'email' || $field->field_type == 'password' || $field->field_type == 'radio' || $field->field_type == 'text') {
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                    <div class="controls">
                        <input type="' . $field->field_type . '" name="' . $field->field_name . '" value="' . $field->field_value . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . '/>
                    </div>';
                } else if ($field->field_type == 'selectbox') {
                    $opt_html = '';
                    if ($field->sel_option_val) {
                        $opt_arr = explode(",", $field->sel_option_val);
                        foreach ($opt_arr as $opt) {
                            list($val, $show) = explode("=>", $opt);
                            $opt_html.= '<option value="' . trim($val) . '">' . trim($show) . '</option>';
                        }
                    }
                    ($field->field_placeholder) ? $placehol = '<option value="">' . $field->field_placeholder . '</option>' : $placehol = '';
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                            <select id="' . $field->field_id . '" name="' . $field->field_name . '" class="' . $field->field_class . '"' . $f_req . '>
                                ' . $placehol . '
                                ' . $opt_html . '
                            </select>';
                } else if ($field->field_type == 'textarea') {
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                    <div class="controls">
                        <textarea name="' . $field->field_name . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . ' rows="4">' . $field->field_value . '</textarea>
                    </div>';
                } else if ($field->field_type == 'button' || $field->field_type == 'reset' || $field->field_type == 'submit') {
                    $html_btn.= '<input type="' . $field->field_type . '" name="' . $field->field_name . '" value="' . $field->field_value . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . '/> ';
                }
            }
            if ($form_data->captcha) {
                $html.= $this->showCaptcha();
            }
            $html.= '<br><div class="form-actions">' . $html_btn . '</div>';
            $html.= '</form>';
            $new_content = str_replace('[?]{=forms:' . $frm_name . '}[?]', $html, $content);
            return $new_content;
        } else {
            return $content;
        }
    }

    public function clear_all_error_log() {
        $logs_path = APPPATH . 'logs/';

        $handle = opendir($logs_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($logs_path . '/' . $file);
            }
        }
        closedir($handle);
    }
    
    public function clear_all_cache() {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');

        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }
    
    public function clear_uri_cache($uri) {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        @unlink($cache_path . '/' . md5($uri));
    }
    
    public function getCurlreCaptData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);
        return $obj->success;
    }

    public function chkCaptchaRes() {
        $config = $this->load_config();
        $respone = '';
        if($config->googlecapt_active){
            $recaptcha = $_POST['g-recaptcha-response'];
            if (!empty($recaptcha)) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify" . "?secret=" . $config->googlecapt_secretkey . "&response=" . $recaptcha . "&remoteip=" . $ip;
                $res = $this->getCurlreCaptData($url);
                if ($res) { 
                    $respone = $res;
                } else {
                    $respone = '';
                }
            } else {
                $respone = '';
            }
        }else{
            $respone = 'NOT_ACTIVE';
        }
        return $respone;
    }
    
    public function showCaptcha() {
        $config = $this->load_config();
        $html = '';
        if($config->googlecapt_active){
            $html = '<div class="g-recaptcha" style="transform:scale(0.75) !important; -webkit-transform:scale(0.75) !important; transform-origin:0 0 !important; -webkit-transform-origin:0 0 !important;" data-sitekey="'.$config->googlecapt_sitekey.'"></div>';
        }
        return $html;
    }
    
    public function saveLinkStats($link) {
        $link = str_replace(BASE_URL.'/linkstats?url=', '', $link);
        $this->db->set('link', $link, TRUE);
        $this->db->set('ip_address', $this->input->ip_address(), TRUE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->insert('link_statistic');
    }
    
    public function memberLogin($email, $password) {
        if ($this->Csz_model->chkCaptchaRes() == '') {
            return 'CAPTCHA_WRONG';
        } else {
            $this->db->select("*");
            $this->db->where("email", $email);
            $this->db->where("password", $password);
            $this->db->where("active", '1');
            $this->db->limit(1, 0);
            $query = $this->db->get("user_admin");
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data = array(
                        'user_admin_id' => $rows->user_admin_id,
                        'admin_name' => $rows->name,
                        'admin_email' => $rows->email,
                        'admin_type' => $rows->user_type,
                        'admin_hash' => $rows->md5_hash,
                        'admin_logged_in' => TRUE,
                    );
                    $this->session->set_userdata($data);
                    return 'SUCCESS';
                }
            } else {
                return 'INVALID';
            }
        }
    }
    
    public function getLabelLang($name) {
        if(!$this->session->userdata('fronlang_iso')){
            $this->setSiteLang();
        }
        $lang = $this->session->userdata('fronlang_iso');
        if($lang){
            $sel_name = 'lang_'.$lang;
            $this->db->select($sel_name);
            $this->db->where("name", $name);
            $this->db->limit(1, 0);
            $query = $this->db->get("general_label");
            if ($query && $query->num_rows() > 0) {
                if($query->row()->$sel_name) return $query->row()->$sel_name; 
                else return "This label is untranslated!";         
            }else{
                return "This language isn't sync! (lang_".$lang.")";
            }
        }else{
            return FALSE;
        }  
    }
    
    public function createMember() {
        // Create the user account
        $md5_hash = md5(time() + mt_rand(1, 99999999));
        $data = array(
            'name' => 'Member User',
            'email' => $this->input->post('email', TRUE),
            'password' => md5($this->input->post('password', TRUE)),
            'user_type' => 'member',
            'active' => 0,
            'md5_hash' => $md5_hash,
        );
        $this->db->set('md5_lasttime', 'NOW()', FALSE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('user_admin', $data);
        return $md5_hash;
    }
    
    public function updateMember($id) {
        // update the user account
        if($this->input->post('year', TRUE) && $this->input->post('month', TRUE) && $this->input->post('day', TRUE)){
            $birthday = $this->input->post('year', TRUE).'-'.$this->input->post('month', TRUE).'-'.$this->input->post('day', TRUE);
        }else{
            $birthday = '';
        }
        if ($this->input->post('del_file')) {
            $upload_file = '';
            unlink('photo/profile/' . $this->input->post('del_file', TRUE));
        } else {
            $upload_file = $this->input->post('picture');
            if ($_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg' || $_FILES['file_upload']['type'] == 'image/gif') {
                $paramiter = '_1';
                $photo_id = time();
                $uploaddir = 'photo/profile/';
                $file_f = $_FILES['file_upload']['tmp_name'];
                $file_name = $_FILES['file_upload']['name'];
                $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, $this->input->post('picture', TRUE), $uploaddir, $photo_id, $paramiter);
            }
        }
        $this->db->set('name', $this->input->post("name", TRUE), TRUE);
        $this->db->set('email', $this->input->post('email', TRUE), TRUE);
        if ($this->input->post('password') != '') {
            $this->db->set('password', md5($this->input->post('password', TRUE)), TRUE);
            $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
        }
        $this->db->set('first_name', $this->input->post("first_name", TRUE), TRUE);
        $this->db->set('last_name', $this->input->post("last_name", TRUE), TRUE);
        $this->db->set('birthday', $birthday, TRUE);
        $this->db->set('gender', $this->input->post("gender", TRUE), TRUE);
        $this->db->set('address', $this->input->post("address", TRUE), TRUE);
        $this->db->set('phone', $this->input->post("phone", TRUE), TRUE);
        $this->db->set('picture', $upload_file, TRUE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('user_admin_id', $id);
        $this->db->update('user_admin');
    }
    
}
