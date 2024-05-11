<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Login</h1>
            <?php echo $this->session->flashdata('message'); ?>
            <?php echo form_open('admin/login', 'class="form"'); ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="identity" value="<?php echo set_value('identity'); ?>" id="identity" placeholder="Email">
                    <?php echo form_error('identity', '<span class="badge badge-danger">','</span>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" id="password" placeholder="******">
                    <?php echo form_error('password', '<span class="badge badge-danger">','</span>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2">Remember</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember"> Remember me?
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
            
            <?php echo form_close();?>
        </div>
    </div>
</div>