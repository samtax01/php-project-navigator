<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your favicon is ready!</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" type='text/css' href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#myModal").modal('show');
            });
        </script>
    </head>
<body>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Click & Save your Favicon</h5>
                </div>
                <div class="modal-body">
                    <p><img src="<?php echo base_url(); ?>/upload/<?php echo $upload_data['file_name']; ?>"> Your favicon is ready, enter this tag in the head of your website.</p>
                    <pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">&quot;shortcut icon&quot;</span> <span class="na">href=</span><span class="s">&quot;/favicon.ico&quot;</span> <span class="na">type=</span><span class="s">&quot;image/x-icon&quot;</span><span class="nt">&gt;</span></pre>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo base_url(); ?>upload/download/<?php echo $upload_data['file_name'];?>" class="btn btn-danger">Download</a> 
                    <a href="<?php echo base_url(); ?>" class="btn btn-success">Create Another</a>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>             