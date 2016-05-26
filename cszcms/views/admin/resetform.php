<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="text-center"><span style="font-size:36px;color:#ff6f00;font-family: 'Kaushan Script','Helvetica Neue',Helvetica,Arial,cursive;"><?php echo $this->Headfoot_html->getLogo();?></span></div>
            <div class="text-left" style="padding:30px;">
                <center><h3 class="form-signin-heading"><?php echo  $this->lang->line('forgot_reset') ?></h3></center><br><br>
                <?php if(!$success_chk){ ?>
                <div class="control-group">
                    <label class="control-label" for="email"><?php echo $this->lang->line('forgot_email'); ?>: <?php echo $email?></label>
                </div>
                <div class="control-group">		
                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>									
                    <label class="control-label" for="password"><?php echo $this->lang->line('user_new_pass'); ?>*</label>
                    <?php
                    $data = array(
                        'name' => 'password',
                        'id' => 'password',
                        'required' => 'required',
                        'autofocus' => 'true',
                        'class' => 'form-control',
                        'value' => set_value('password', '', FALSE)
                    );
                    echo form_password($data);
                    ?>			
                </div> <!-- /control-group -->

                <div class="control-group">	
                    <?php echo form_error('con_password', '<div class="error">', '</div>'); ?>									
                    <label class="control-label" for="con_password"><?php echo $this->lang->line('user_new_confirm'); ?>*</label>
                    <?php
                    $data = array(
                        'name' => 'con_password',
                        'id' => 'con_password',
                        'required' => 'required',
                        'autofocus' => 'true',
                        'class' => 'form-control',
                        'value' => set_value('con_password', '', FALSE)
                    );
                    echo form_password($data);
                    ?>			
                </div> <!-- /control-group -->
                <br>
                <button class="btn btn-lg btn-primary" type="submit" id="forget_submit"><?php echo $this->lang->line('forgot_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-lg" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo  BASE_URL . '/admin' ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
                <?php echo  form_close() ?>
                <?php }if($success_chk){ ?>
                    <center>
                        <p class="success"><?php echo $this->lang->line('forgot_complete'); ?></p>
                        <br>
                        <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo BASE_URL . '/admin'?>"><?php echo $this->lang->line('btn_back'); ?></a>
                    </center>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>