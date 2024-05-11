<section class="jumbotron">
    <div class="container">
        <h1 class="jumbotron-heading">Create Favicon</h1>
        <p class="lead text-muted">Q09ERUxJU1QuQ0MgLSBFeGNsdXNpdmUgc2NyaXB0cywgcGx1Z2lucyAmIG1vYmlsZSE=</p>
        <div class="row m-b-1">
            <div class="col-lg-8">
                <?php echo form_open_multipart($this->uri->uri_string(), ''); ?>
                
                <div class="form-group row">
                    <label for="url" class="col-2 col-form-label"><?php echo $this->lang->line('website'); ?></label>
                    <div class="col-10">
                        <input type="url" name="url" value="<?php echo set_value('url'); ?>" placeholder="http://www.google.com" class="form-control">
                        <?php echo form_error('url', '<span class="badge badge-danger">', '</span>'); ?>
                    </div>
                </div>
                
                <div class="form-group inputDnD">
                    <label class="sr-only" for="inputFile">File Upload</label>
                    <input type="file" readonly="readonly" name="image_name" class="form-control-file text-primary font-weight-bold" id="image_name" onchange="readUrl(this)" data-title="<?php echo $this->lang->line('dragdrop'); ?>">
                    <?php echo form_error('image_name', '<span class="badge badge-danger">', '</span>'); ?>
                </div>
                
                <div class="form-group">
                    <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                        <input type="checkbox" class="custom-control-input" name="public" id="public" value="1" tabindex="0" checked="1">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo $this->lang->line('public'); ?></span>
                    </label>
                </div>
                
                <input type="submit" class="btn btn-success btn-block" value="<?php echo $this->lang->line('create'); ?>" />
                <?php echo form_close(); ?>
            </div>
            
            <div class="col-lg-4">
                <?php $this->load->view('themes/default/banner'); ?>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center pull-center">
            <?php foreach($favicon as $item): ?>
            <a href="<?php echo $item['url']; ?>">
                <img src="<?php echo base_url().'upload/'.$item['image_name'].'.ico'; ?>" alt="..." class="rounded-circle" width="25" height="25">
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>