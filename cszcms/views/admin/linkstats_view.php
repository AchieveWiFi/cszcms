<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo  $this->lang->line('linkstats_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('linkstats_header') ?></div>
        <form action="<?php echo BASE_URL . '/admin/linkstats/'; ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label>
                <label class="control-label" for="start_date"><?php echo $this->lang->line('startdate_field'); ?>: <input type="text" name="start_date" id="start_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('start_date');?>"></label>
                <label class="control-label" for="end_date"><?php echo $this->lang->line('enddate_field'); ?>: <input type="text" name="end_date" id="end_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('end_date');?>"></label>
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="60%" class="text-center"><?php echo $this->lang->line('linkstats_url'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('linkstats_count'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('linkstats_dateime'); ?></th>
                        <th width="15%"></th><?php echo $this->lang->line('linkstats_dateime'); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($linkstats as $u) {
                        echo '<tr>';
                        echo '<td>' . $u['link'] . '</td>';
                        $where_arr = array('link'=>$u['link']);
                        echo '<td class="text-center">' . number_format($this->Csz_model->countData('link_statistic', $where_arr)) . '</td>';
                        echo '<td class="text-center">' . $u['timestamp_create'] . '</td>';
                        echo '<td class="text-center"><a href="'.BASE_URL.'/admin/linkstats/view/?url=' . $u['link'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-eye-open"></i>  '.$this->lang->line('btn_view').'</a>';
                        if($this->session->userdata('admin_type') == 'admin'){
                            echo ' &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('user_delete_message').'\')" href="'.BASE_URL.'/admin/linkstats/deleteByURL/'.$u['link'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a>';
                        }
                        echo '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
