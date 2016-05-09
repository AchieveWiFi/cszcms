CREATE TABLE IF NOT EXISTS `footer_social` (
  `footer_social_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_name` varchar(255) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`footer_social_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

INSERT INTO `footer_social` (`footer_social_id`, `social_name`, `social_url`, `active`, `timestamp_update`) VALUES
(1, 'twitter', '', 0, '2016-05-06 15:50:59'),
(2, 'facebook', '', 0, '2016-05-06 15:50:59'),
(3, 'linkedin', '', 0, '2016-05-06 15:50:59'),
(4, 'youtube', '', 0, '2016-05-06 15:50:59'),
(5, 'google', '', 0, '2016-05-06 15:50:59'),
(6, 'pinterest', '', 0, '2016-05-06 15:50:59'),
(7, 'foursquare', '', 0, '2016-05-06 15:50:59'),
(8, 'myspace', '', 0, '2016-05-06 15:50:59'),
(9, 'soundcloud', '', 0, '2016-05-06 15:50:59'),
(10, 'spotify', '', 0, '2016-05-06 15:50:59'),
(11, 'lastfm', '', 0, '2016-05-06 15:50:59'),
(12, 'vimeo', '', 0, '2016-05-06 15:50:59'),
(13, 'dailymotion', '', 0, '2016-05-06 15:50:59'),
(14, 'vine', '', 0, '2016-05-06 15:50:59'),
(15, 'flickr', '', 0, '2016-05-06 15:50:59'),
(16, 'instagram', '', 0, '2016-05-06 15:50:59'),
(17, 'tumblr', '', 0, '2016-05-06 15:50:59'),
(18, 'reddit', '', 0, '2016-05-06 15:50:59'),
(19, 'envato', '', 0, '2016-05-06 15:50:59'),
(20, 'github', '', 0, '2016-05-06 15:50:59'),
(21, 'tripadvisor', '', 0, '2016-05-06 15:50:59'),
(22, 'stackoverflow', '', 0, '2016-05-06 15:50:59'),
(23, 'persona', '', 0, '2016-05-06 15:50:59');

CREATE TABLE IF NOT EXISTS `form_contactus_en` (
  `form_contactus_en_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  PRIMARY KEY (`form_contactus_en_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `form_field` (
  `form_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_main_id` int(11) NOT NULL,
  `field_type` varchar(100) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_id` varchar(255) NOT NULL,
  `field_class` varchar(255) NOT NULL,
  `field_placeholder` varchar(255) NOT NULL,
  `field_value` varchar(255) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `sel_option_val` text NOT NULL,
  `field_required` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`form_field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `form_field` (`form_field_id`, `form_main_id`, `field_type`, `field_name`, `field_id`, `field_class`, `field_placeholder`, `field_value`, `field_label`, `sel_option_val`, `field_required`, `timestamp_create`, `timestamp_update`) VALUES
(1, 1, 'text', 'name', 'name', 'form-control', '', '', 'Name', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(2, 1, 'email', 'email', 'email', 'form-control', '', '', 'Email Address', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(3, 1, 'selectbox', 'contact_type', 'contact_type', 'form-control', '-- Choose Type --', '', 'Contact Type', 'question=>Question, contact us=>Contact Us, service=>Service', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(4, 1, 'textarea', 'message', 'message', 'form-control', '', '', 'Message', '', 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(5, 1, 'submit', 'submit', 'submit', 'btn btn-primary', '', 'Send now', '', '', 0, '2016-05-02 19:15:50', '2016-05-02 19:15:50'),
(6, 1, 'reset', 'reset', 'reset', 'btn btn-default', '', 'Reset', '', '', 0, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

CREATE TABLE IF NOT EXISTS `form_main` (
  `form_main_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `form_enctype` varchar(255) NOT NULL,
  `form_method` varchar(255) NOT NULL,
  `sendmail` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `captcha` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`form_main_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `form_main` (`form_main_id`, `form_name`, `form_enctype`, `form_method`, `sendmail`, `email`, `subject`, `active`, `captcha`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'contactus_en', '', 'post', 1, 'cskaza@gmail.com', 'Contact us from the CSZ-CMS website', 1, 1, '2016-05-02 19:15:50', '2016-05-02 19:15:50');

CREATE TABLE IF NOT EXISTS `lang_iso` (
  `lang_iso_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_iso` varchar(10) NOT NULL,
  `active` int(2) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`lang_iso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Language ISO' AUTO_INCREMENT=3 ;

INSERT INTO `lang_iso` (`lang_iso_id`, `lang_name`, `lang_iso`, `country`, `country_iso`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'English', 'en', 'United Kingdom', 'gb', 1, '2016-03-29 15:16:23', '2016-03-31 15:28:58'),
(2, 'ไทย', 'th', 'ประเทศไทย', 'th', 1, '2016-03-31 15:05:59', '2016-03-31 15:29:32');

CREATE TABLE IF NOT EXISTS `pages` (
  `pages_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_keywords` varchar(255) NOT NULL,
  `page_desc` text NOT NULL,
  `content` text NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`pages_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `pages` (`pages_id`, `page_name`, `page_url`, `lang_iso`, `page_title`, `page_keywords`, `page_desc`, `content`, `active`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'home', 'en', 'CSZ Home', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english, homepage', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<header id="myCarousel" class="carousel slide">\r\n<ol class="carousel-indicators">\r\n<li data-target="#myCarousel" data-slide-to="0" class="active"></li>\r\n<li data-target="#myCarousel" data-slide-to="1"></li>\r\n<li data-target="#myCarousel" data-slide-to="2"></li>\r\n</ol>\r\n<!-- Wrapper for slides -->\r\n<div class="carousel-inner">\r\n<div class="item active">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide One"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 1</h2>\r\n</div>\r\n</div>\r\n<div class="item">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide Two"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 2</h2>\r\n</div>\r\n</div>\r\n<div class="item">\r\n<div class="fill"><img src="http://placehold.it/1900x540&text=Slide Three"></div>\r\n<div class="carousel-caption">\r\n<h2>Caption 3</h2>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- Controls --> <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="icon-prev"></span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="icon-next"></span> </a></header><!-- Start Jumbotron -->\r\n<div class="jumbotron">\r\n<div class="container">\r\n<h1>Hello, world!</h1>\r\n<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique. <span xss="removed">test</span></p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>Heading</h2>\r\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n<p><a class="btn btn-default" href="#" role="button">View details »</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- /container -->', 1, '2016-03-08 10:12:56', '2016-05-09 11:00:51'),
(2, 'หน้าแรก', 'หน้าแรก', 'th', 'CSZ หน้าแรก', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, หน้าแรก', 'CSKAZA Template สำหรับ Bootstrap ด้วย CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>สวัสดี, ชาวโลก!</h1>\r\n<p>นี้คือตัวอย่างรูปแบบเว็บไซต์สำหรับตัวอย่าง. และรวมไปถึงส่วนของ jumbotron.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">ศึกษาเพิ่มเติม &raquo;</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-4">\r\n<h2>หัวข้อ</h2>\r\n<p>ทดสอบเนื้อหาโดย CSKAZA.</p>\r\n<p><a class="btn btn-default" href="#" role="button">ดูรายละเอียด &raquo;</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>หัวข้อ</h2>\r\n<p>ทดสอบเนื้อหาโดย CSKAZA.</p>\r\n<p><a class="btn btn-default" href="#" role="button">ดูรายละเอียด &raquo;</a></p>\r\n</div>\r\n<div class="col-md-4">\r\n<h2>หัวข้อ</h2>\r\n<p>ทดสอบเนื้อหาโดย CSKAZA.</p>\r\n<p><a class="btn btn-default" href="#" role="button">ดูรายละเอียด &raquo;</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- /container -->', 1, '2016-03-30 10:01:41', '2016-04-28 11:33:39'),
(3, 'About Us', 'about-us', 'en', 'CSZ-CMS About Us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, aboutus', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>About Us!</h1>\r\n<p>CSKAZA Template for Bootstrap with CSZ-CMS. CSZ-CMS build by CSKAZA.</p>\r\n<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>\r\n</div>\r\n</div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="col-md-6">\r\n<div class="panel panel-default">\r\n<div class="panel-heading">Panel heading</div>\r\n<div class="panel-body">\r\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<p></p>', 1, '2016-04-11 15:17:18', '2016-05-01 15:16:13'),
(4, 'Contact Us', 'contact-us', 'en', 'CSZ-CMS Contact us', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, contact us', 'CSKAZA Template for Bootstrap with CSZ-CMS', '<div class="jumbotron">\r\n<div class="container">\r\n<h1>Contact us!</h1>\r\n<p>If you want to contact us please use this form below. Or send the email to <a href="mailto:info@cskaza.xyz">info@cskaza.xyz</a></p>\r\n</div>\r\n</div>\r\n<div class="container"></div>\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-6">\r\n<h2>Google Map</h2>\r\n<p><iframe width="450" height="315" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.168282092751!2d98.37285931425068!3d7.877454308128998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zN8KwNTInMzguOCJOIDk4wrAyMiczMC4yIkU!5e0!3m2!1sen!2sth!4v1462104596003" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>\r\n</div>\r\n<div class="col-md-6">\r\n<h2>Contact Form</h2>\r\n<p>If you have any question please send this from.</p>\r\n<p>[?]{=forms:contactus_en}[?]</p>\r\n</div>\r\n</div>\r\n</div>\r\n<p></p>\r\n<p></p>', 1, '2016-04-30 16:57:16', '2016-05-01 19:11:36');

CREATE TABLE IF NOT EXISTS `page_menu` (
  `page_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `lang_iso` varchar(10) NOT NULL,
  `pages_id` int(11) NOT NULL,
  `other_link` varchar(512) NOT NULL,
  `drop_menu` int(11) NOT NULL,
  `drop_page_menu_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `arrange` int(11) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`page_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `page_menu` (`page_menu_id`, `menu_name`, `lang_iso`, `pages_id`, `other_link`, `drop_menu`, `drop_page_menu_id`, `active`, `arrange`, `timestamp_create`, `timestamp_update`) VALUES
(1, 'Home', 'en', 1, '', 0, 0, 1, 1, '2016-03-25 13:00:08', '2016-04-30 16:58:07'),
(2, 'Drop Menu', 'en', 0, '', 1, 0, 1, 4, '2016-03-27 15:54:15', '2016-04-30 16:58:07'),
(3, 'Google', 'en', 0, 'http://www.google.com', 0, 2, 1, 1, '2016-03-27 15:55:01', '2016-04-30 16:58:07'),
(4, 'Facebook', 'en', 0, 'http://www.faebook.com', 0, 2, 1, 2, '2016-03-28 15:22:12', '2016-04-30 16:58:07'),
(5, 'หน้าแรก', 'th', 2, '', 0, 0, 1, 1, '2016-03-30 10:06:37', '2016-03-31 15:08:12'),
(6, 'About Us', 'en', 3, '', 0, 0, 1, 2, '2016-04-11 15:01:03', '2016-04-30 16:58:07'),
(7, 'Contact Us', 'en', 4, '', 0, 0, 1, 3, '2016-04-30 16:58:02', '2016-04-30 16:58:07');

CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_footer` text NOT NULL,
  `default_email` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `themes_config` varchar(255) NOT NULL,
  `admin_lang` varchar(255) NOT NULL,
  `additional_js` text NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `settings` (`settings_id`, `site_name`, `site_logo`, `site_footer`, `default_email`, `keywords`, `themes_config`, `admin_lang`, `additional_js`, `timestamp_update`) VALUES
(1, 'CSZ-CMS Demo', '2016/1461303849_1-org.png', '&copy; 2016 CSZ-CMS Demo', 'cskaza@gmail.com', 'CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english', 'cszdefault', 'english', '', '2016-05-09 11:07:43');

CREATE TABLE IF NOT EXISTS `upload_file` (
  `upload_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(10) NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`upload_file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_admin` (
  `user_admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `md5_hash` varchar(255) NOT NULL,
  `md5_lasttime` datetime NOT NULL,
  `timestamp_create` datetime NOT NULL,
  `timestamp_update` datetime NOT NULL,
  PRIMARY KEY (`user_admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;