<div class="clearfix">
    <div class="col-md-12 login-screen">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert-msg">
                    <input type="hidden" class="msg-fields-required" value="<?php echo _t('All fields are required'); ?>" />
                    <div class="alert-output"></div>
                </div>
                <form role="form">
                    <div class="form-group">
                        <input type="email" class="form-control" id="login-username" placeholder="<?php echo _t('Username'); ?>">
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control" id="login-password" placeholder="<?php echo _t('Password'); ?>">
                    </div>
                    <a href="javascript:void(0)" class="btn btn-default" id="do-login"><?php echo _t('Login'); ?></a>
                </form>
            </div>
        </div>
    </div>
</div>
