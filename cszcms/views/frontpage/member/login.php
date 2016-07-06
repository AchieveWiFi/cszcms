<div class="container">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <br><br><br>
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->Csz_model->getLabelLang('login_heading') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <div class="text-center">
                    <?php
                    if ($error) {
                        if ($error == 'INVALID') {
                            echo "<span class=\"error\">" . $this->Csz_model->getLabelLang('login_incorrect') . "</span><br><br>";
                        }
                        if ($error == 'CAPTCHA_WRONG') {
                            echo "<span class=\"error\">" . $this->Csz_model->getLabelLang('captcha_wrong') . "</span><br><br>";
                        }
                    }
                    ?>
                    </div>
                    <?php echo form_open(BASE_URL . '/member/login/check') ?>
                    <input type="hidden" id="url_return" name="url_return" value="<?php echo $this->input->get('url_return', TRUE)?>"/>
                    <label for="email" class="control-label"><?php echo $this->Csz_model->getLabelLang('login_email') ?>*</label>
                    <?php
                    $data = array(
                        'name' => 'email',
                        'id' => 'email',
                        'type' => 'email',
                        'class' => 'form-control',
                        'required' => 'required',
                        'autofocus' => 'true',
                        'value' => set_value('email'),
                        'placeholder' => $this->Csz_model->getLabelLang('login_email')
                    );
                    echo form_input($data);
                    ?>
                    <label for="password" class="control-label"><?php echo $this->Csz_model->getLabelLang('login_password') ?>*</label>
                    <?php
                    $data = array(
                        'name' => 'password',
                        'id' => 'password',
                        'class' => 'form-control',
                        'required' => 'required',
                        'value' => set_value('password'),
                        'placeholder' => $this->Csz_model->getLabelLang('login_password')
                    );
                    echo form_password($data);
                    ?>
                    <br>
                    <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit"><?php echo $this->Csz_model->getLabelLang('login_signin'); ?></button>
                    <?php echo form_close() ?>
                </div>
                <div class="panel-footer text-center"><a href="<?php echo BASE_URL; ?>/member/register"><?php echo $this->Csz_model->getLabelLang('login_register'); ?></a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo BASE_URL; ?>/member/forgot"><?php echo $this->Csz_model->getLabelLang('login_forgetpwd'); ?></a></div>
            </div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs"></div>
    </div>
</div>