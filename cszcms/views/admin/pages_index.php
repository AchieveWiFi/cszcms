<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('pages_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('pages_header') ?>  <a role="button" href="<?php echo BASE_URL?>/admin/pages/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('pages_addnew') ?></a></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="29%" class="text-center"><?php echo $this->lang->line('pages_name'); ?></th>
                        <th width="35%" class="text-center"><?php echo $this->lang->line('pages_title'); ?></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pages as $u) {
                        if(!$u['active']){
                            $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                        }else{
                            $inactive = '';
                        }
                        if($u['pages_id'] == 1){
                            $default_txt = ' <i class="glyphicon glyphicon-lock"></i>';
                        }else{
                            $default_txt = '';
                        }
                        echo '<tr>';
                        echo '<td'.$inactive.' class="text-center">' . $u['pages_id'] . '</td>';
                        echo '<td'.$inactive.'>' . $u['page_name'] . ''.$default_txt.'</td>';
                        echo '<td'.$inactive.'>' . $u['page_title'] . '</td>';
                        echo '<td class="text-center"'.$inactive.'><i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($u['lang_iso']).'"></i></td>';                        
                        echo '<td class="text-center"><a href="'.BASE_URL.'/admin/pages/edit/' . $u['pages_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('pages_delete_message').'\')" href="'.BASE_URL.'/admin/pages/delete/'.$u['pages_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
        <br>
        <span class="warning"><i class="glyphicon glyphicon-lock"></i> <?php echo  $this->lang->line('default_data_remark') ?></span>
    </div>
</div>
