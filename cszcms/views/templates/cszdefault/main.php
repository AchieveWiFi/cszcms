<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?=doctype('html5')?>
<html lang="en">
    <head>
        <?=$meta_tags?>
        <?=link_tag('templates/cszdefault/imgs/favicon.ico', 'shortcut icon', 'image/ico');?>
        <title><?=$title?></title>
        <!-- Bootstrap Core CSS -->
        <?= $core_css ?>        
        <!-- Custom CSS -->
        <?= link_tag('templates/cszdefault/css/cszdefault.min.css') ?>        
        <!-- Custom Fonts -->        
        <?= link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Kaushan+Script') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700') ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="page-top" class="index">        
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="<?=BASE_URL?>"><?=$this->Headfoot_html->getLogo();?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="mainmenu-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?=$this->Headfoot_html->topmenu($cur_page);?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        
        <!-- Start For Content -->
        <?php echo $content; ?>
        <!-- End For Content -->
        
        <div class="container">
            <footer>
                <div class="container">
                    <hr>
                    <div class="row">
                        <div class="col-md-8 div-copyright">
                            <? /*$this->Headfoot_html->langMenu(1=Show flag only, 
                             * 2=Show flag and Language, 
                             * 3=Show flag and Country,
                             * Null or 0=Show Full detail)*/ ?>
                            <?=$this->Headfoot_html->langMenu(2);?>
                            <?=$this->Headfoot_html->footer();?>
                        </div>
                        <div class="col-md-4 div-social hidden-sm hidden-xs">
                            <br>
                            <?=$this->Headfoot_html->getSocial();?>
                        </div>
                        <div class="col-md-4 div-social-mobile visible-sm visible-xs">
                            <br>
                            <?=$this->Headfoot_html->getSocial();?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?=$core_js?>
    </body>
</html>