<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Edit Account</h1>
            <?php echo $this->session->flashdata('message'); ?>
            <?php echo form_open('admin/account', 'class="form"'); ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <?php echo form_input($email);?>
                <?php echo form_error('email', '<span class="badge badge-danger">','</span>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                    <?php echo form_input($password);?>
                    <?php echo form_error('password', '<span class="badge badge-danger">','</span>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password Confirm</label>
                <div class="col-sm-10">
                    <?php echo form_input($password_confirm);?>
                    <?php echo form_error('password_confirm', '<span class="badge badge-danger">','</span>'); ?>
                </div>
            </div>
            
            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>
            
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </div>
            
            <?php echo form_close();?>
        </div>
    </div>
</div>