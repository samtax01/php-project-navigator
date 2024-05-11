<?php @session_start(); ?>
<!DOCTYPE html>

<html>

    <head>

        <title>Xamtax Explorer [ <?php echo $lister->getListedPath(); ?> ]</title>
        <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/img/folder.png">

        <!-- STYLES    //maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css   -->
        <link rel="stylesheet" href="<?php echo THEMEPATH; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo THEMEPATH; ?>/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/css/style.css">

        <!-- SCRIPTS -->
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/jquery.min.js"></script>
        <script src="<?php echo THEMEPATH; ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/directorylister.js"></script>

        <!-- FONTS -->
        <link rel="stylesheet" type="text/css"  href="//fonts.googleapis.com/css?family=Cutive+Mono">

        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <style>
        	//#page-content{ background: black !important;color:white }
    	</style>

        <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>
    </head>

    <body style="">

        <div id="page-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">



                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>

                <p class="navbar-text">
                    
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>

                <div class="navbar-right">

                    <ul id="page-top-nav" class="nav navbar-nav">
                        <li>
                            <a href="javascript:void(0)" id="page-top-link">
                                <i class="fa fa-arrow-circle-up fa-lg"></i>
                            </a>
                        </li>
                    </ul>

                    <?php  if ($lister->isZipEnabled()): ?>
                        <ul id="page-top-download-all" class="nav navbar-nav">
                            <li>
                                <a href="?zip=<?php echo $lister->getDirectoryPath(); ?>" id="download-all-link">
                                    <i class="fa fa-download fa-lg"></i>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <div id="page-content" class="container">

            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>

            <?php if($lister->getSystemMessages()): ?>
                <?php foreach ($lister->getSystemMessages() as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div id="directory-list-header">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-10">File</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-right">Size</div>
                    <div class="col-md-3 col-sm-4 hidden-xs text-right">Last Modified</div>
                </div>
            </div>

            <ul id="directory-listing" class="nav nav-pills nav-stacked">

                <?php foreach($dirArray as $name => $fileInfo): ?>
                    <li data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
                        <a href="<?php echo $fileInfo['url_path']; ?>" class="clearfix" data-name="<?php echo $name; ?>">
                            <div class="row">
                                <span class="file-name col-md-7 col-sm-6 col-xs-9">
                                    <i class="fa <?php echo $fileInfo['icon_class']; ?> fa-fw"></i>
                                    <?php echo $name; ?>
                                </span>

                                <span class="file-size col-md-2 col-sm-2 col-xs-3 text-right">
                                    <?php echo $fileInfo['file_size']; ?>
                                </span>

                                <span class="file-modified col-md-3 col-sm-4 hidden-xs text-right">
                                    <?php echo $fileInfo['mod_time']; ?>
                                </span>
                            </div>
                        </a>

                        <?php if(is_file($fileInfo['file_path'])): ?>
                            <div> 

                                <?php
                                    if(isset($_REQUEST['save_url'])){
                                        $url = $_REQUEST['save_url'];

                                        $_SESSION['localhost_directory_lister']['recent_file'][] = $url;
                                        header('Location: '.$url);

                                        echo '<script type="text/javascript">';
                                        echo '  window.location.href="'.$url.'";';
                                        echo '</script>';

                                        echo '<noscript>';
                                        echo '  <meta http-equiv="refresh" content="0;url='.$url.'" />';
                                        echo '</noscript>'; exit;
                                    }



                                ?>



                                <a href="javascript:void(0)" class="file-info-button"> <i class="fa fa-info-circle"></i> </a> 
                                <a href="<?php echo ($_SERVER['REQUEST_URI']).'&save_url='.$fileInfo['url_path']; ?>" style="float:right;margin-top:-50px;margin-right:-40px;"> <i class="fa fa-fw fa-play"></i></a>
                            </div>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>

            </ul>
        </div>

        <br/><br/><br/><br/><br/><br/><br/><br/><hr/>
        <div class="container">
            <?php  file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_header.php");  ?>
            <br/><br/><br/><br/><hr/>

            <h3>Recent Play Link</h3>
            <ul>
                <?php
                    $data = @$_SESSION['localhost_directory_lister']['recent_file'];
                    $data ??= [];
                    foreach(array_reverse($data) as $path){ ?>
                    <li style='list-style-type:none;padding:10px;border:1px solid silver;margin:1px solid gray;overflow:auto;word-wrap: auto;'><a href="<?php echo $path ?>" class='clearfix'><?php echo $path ?></a></li>
                <?php  } ?>
            </ul>
                

           

        </div>


        <div id="file-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{modal_header}}</h4>
                    </div>

                    <div class="modal-body">

                        <table id="file-info" class="table table-bordered">
                            <tbody>

                                <tr>
                                    <td class="table-title">MD5</td>
                                    <td class="md5-hash">{{md5_sum}}</td>
                                </tr>

                                <tr>
                                    <td class="table-title">SHA1</td>
                                    <td class="sha1-hash">{{sha1_sum}}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </body>

</html>
