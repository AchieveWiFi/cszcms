<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

    /**
     Article Plugin by CSKAZA
     */
    var $page_url;
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        $this->load->model('plugin/Article_model');
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
            define('THEME', $row->themes_config);
        }
        if(!$this->session->userdata('fronlang_iso')){ 
            $this->Csz_model->setSiteLang();
        }
        if($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0){ 
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang(); 
        }
        if($row->pagecache_time != 0){ $this->db->cache_on(); }
        $this->_init();
        member_helper::plugin_not_active($this->uri->segment(2));
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $this->page_url = $this->uri->segment(2);	
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
    }

    public function index() {
        $row = $this->Csz_model->load_config();
        $title = 'Article | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
        $this->template->set('cur_page', $this->page_url);
        $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."'";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 10;
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/plugin/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 3);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('frontpage/plugin/article_index');
    }
    
    public function category() {
        if($this->uri->segment(4)){
            $cat_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '1' AND active = '1' AND url_rewrite = '".$this->uri->segment(4)."'", '', 1);
            if($cat_row !== FALSE){
                $row = $this->Csz_model->load_config();
                $title = 'Article | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
                $this->template->set('cur_page', $this->page_url);
                $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND cat_id = $cat_row->article_db_id";
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 10;
                $total_row = $this->Csz_model->countData('article_db', $search_arr);
                $num_link = 10;
                $base_url = BASE_URL . '/plugin/article/category/'.$this->uri->segment(4).'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('frontpage/plugin/article_category');
            }else{
                redirect(BASE_URL.'/plugin/article', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/article', 'refresh');
        }
    }
    
    public function search() {
        $p = $this->Csz_model->cleanOSCommand($this->input->get('p', TRUE));
        if ($p) {
            $row = $this->Csz_model->load_config();
            $title = 'Article Search | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);
            $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND (title LIKE '%" . $p . "%' OR keyword LIKE '%" . $p . "%')";
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('article_db', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/article/search/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);
            $this->template->setSub('searchtxt', $p);

            //Load the view
            $this->template->loadSub('frontpage/plugin/article_search');
        } else {
            redirect(BASE_URL . '/plugin/article', 'refresh');
        }
    }
    
    public function archive() {
        if($this->uri->segment(4)){
            $year_arr = array();
            $year_arr = explode('-', $this->uri->segment(4));
            if($year_arr !== FALSE){
                $row = $this->Csz_model->load_config();
                $title = 'Article | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
                $this->template->set('cur_page', $this->page_url);
                if(count($year_arr) == 1){
                    $this->template->setSub('category_name', $year_arr[0]);
                    $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND timestamp_create LIKE '".$year_arr[0]."-%'";
                }elseif(count($year_arr) == 2){
                    $this->template->setSub('category_name', date('F', mktime(0, 0, 0, $year_arr[1], 10)).' '.$year_arr[0]);
                    $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND timestamp_create LIKE '".$year_arr[0]."-".str_pad($year_arr[1], 2, '0', STR_PAD_LEFT)."%'";
                }
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 10;
                $total_row = $this->Csz_model->countData('article_db', $search_arr);
                $num_link = 10;
                $base_url = BASE_URL . '/plugin/article/archive/'.$this->uri->segment(4).'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                

                //Load the view
                $this->template->loadSub('frontpage/plugin/article_archive');
            }else{
                redirect(BASE_URL.'/plugin/article', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/article', 'refresh');
        }
    }
    
    public function view() {
        if($this->uri->segment(4) && $this->uri->segment(5)){
            $art_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '0' AND active = '1' AND article_db_id = '".$this->uri->segment(4)."' AND url_rewrite = '".$this->uri->segment(5)."'", '', 1);
            if($art_row !== FALSE){
                $row = $this->Csz_model->load_config();
                $this->output->cache($row->pagecache_time);
                $title = $art_row->title.' | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($art_row->short_desc,$art_row->keyword,$title,$art_row->main_picture));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('article', $art_row);
                $cat_row = $this->Csz_model->getValue('category_name', 'article_db', "is_category = '1' AND active = '1' AND article_db_id = '".$art_row->cat_id."'", '', 1);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('frontpage/plugin/article_view');
            }else{
                redirect(BASE_URL.'/plugin/article', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/article', 'refresh');
        }
    }
    
    public function rss() {
        // creating rss feed with our most recent 20
        // first load the library
        $this->db->cache_off();
        $this->load->library('feed');
        $row = $this->Csz_model->load_config();
        // create new instance
        $feed = new Feed();
        // set your feed's title, description, link, pubdate and language
        $feed->title = $row->site_name;
        $feed->description = 'Article | ' . $row->site_name;
        $feed->link = BASE_URL.'/plugin/article';
        $search_arr = " is_category = '0' AND active = '1'";
        $limit = 20;
        // get article list
        $article = $this->Csz_admin_model->getIndexData('article_db', $limit, 0, 'timestamp_create', 'desc', $search_arr);
        // add posts to the feed
        if($article !== FALSE){
            foreach ($article as $a)
            {
                // set item's title, author, url, pubdate and description
                $url = BASE_URL.'/plugin/article/view/'.$a['article_db_id'].'/'.$a['url_rewrite'];
                $feed->add($a['title'], $row->site_name, $url, $a['timestamp_create'], $a['short_desc']);
            }
        }
        // show your feed (options: 'atom' (recommended) or 'rss')
        $feed->render('rss');
    }
    
    public function getWidget() {
        // For New Category
        $this->load->library('Xml_writer');
        // Initiate class
        $xml = new Xml_writer;
        $xml->setRootName('csz_widget');
        $xml->initiate();
        // Start Main branch
        $xml->startBranch('plugin'); 
        $xml->addNode('main_url', BASE_URL.'/plugin/article');
        // Get article 10 items
        if ($this->uri->segment(4)) {
            $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->uri->segment(4)."'";
        }else{
            $search_arr = " is_category = '0' AND active = '1'";
        }
        $limit = 20;
        $article = $this->Csz_admin_model->getIndexData('article_db', $limit, 0, 'timestamp_create', 'desc', $search_arr);
        if($article !== FALSE){
            $xml->addNode('null', '0'); // For check item is not empty
            foreach ($article as $row) {
                // start sub branch
                $xml->startBranch('item', array('id' => $row['article_db_id'])); 
                $xml->addNode('sub_url', BASE_URL.'/plugin/article/view/'.$row['article_db_id'].'/'.$row['url_rewrite']);
                $xml->addNode('title', $row['title']);
                $xml->addNode('short_desc', $row['short_desc']);
                if($row['main_picture']){
                    $xml->addNode('photo', BASE_URL.'/photo/plugin/article/'.$row['main_picture']);
                }else{
                    $xml->addNode('photo', BASE_URL.'photo/no_image.png');
                }
                // End sub branch
                $xml->endBranch();
            }
        }else{
            $xml->addNode('null', '1'); // For check item is empty
        }
        // End Main branch 
        $xml->endBranch();
        // Print the XML to screen
        $xml->getXml(true);
        exit();
    }   

}