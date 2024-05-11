


<!DOCTYPE html>
<html><head>
    <title>Easy-Minified</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="./Alchemize_files/style.css">
    <body class="loaded" style="height: 1017px;">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <span class="navbar-brand" data-toggle="modal" data-target="#about">Easy-Minified</span>
                </div>
                <div class="nav navbar-nav navbar-right">
                    <select name="type" class="form-control formats"> <option>Text</option><option>JavaScript</option><option>HTML</option><option>CSS</option><option>XML</option><option>JSON</option></select>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default action compress" data-action="compress" disabled="disabled">Compress</button>
                        <button type="button" class="btn btn-default action prettify" data-action="prettify" disabled="disabled">Prettify</button>
                    </div>
                </div>
            </div>
        </nav>
        <div class="spinner"></div>











        <div class="row">
            <div class="col col-md-6">
                <textarea  name='editor' onkeypress="console.log(this.innerHTML)"  style="width: 100% !important;height: 500px;padding:20px;"></textarea>
            </div>
            <div class="col col-md-6">
                <textarea  name='editor' onkeypress="console.log(this.innerHTML)"  style="width: 100% !important;height: 500px;padding:20px;">
                    <?php
                    //Enable Error
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //error_reporting(E_ALL ^ E_DEPRECATED);


                    include('easytax/EasyTax.php');
                    FileManager1::loadComposerPackage('minify');
                    use MatthiasMullie\Minify\Minify;

                    if(isset($_REQUEST['editor'])){
                        $minifier = new \MatthiasMullie\Minify\CSS();

                        $css = 'body { color: #000000; }';
                        $minifier->add($css);

                        //use MatthiasMullie\Minify;

                       // $sourcePath = '/path/to/source/css/file.css';
                        //$minifier = new Minify\CSS($sourcePath);

// we can even add another file, they'll then be
// joined in 1 output file
                        //$sourcePath2 = '/path/to/second/source/css/file.css';
                        //$minifier->add($sourcePath2);

// or we can just add plain CSS
//                        $css = 'body { color: #000000; }';
//                        $minifier->add($css);

// save minified file to disk
//                        $minifiedPath = '/path/to/minified/css/file.css';
//                        $minifier->minify($minifiedPath);

// or just output the content
                        echo $minifier->minify();


                    }




                    print_r($_REQUEST);


                    ?>
                </textarea>

            </div>
        </div>
<!-- <textarea class="ace_text-input" wrap="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="opacity: 0; font-size: 1px; height: 1px; width: 1px; transform: translate(45px, 16px);"></textarea>-->

        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <div class="container-fluid">
                <div class="nav navbar-nav navbar-left">
                    <div class="status format">Text</div>
                    <div class="status message">Drag a file or paste from the clipboard </div>
                </div>
                <div class="nav navbar-nav navbar-right"><button  class="btn btn-danger pull-right" typeof="submit">Minified</button>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-info active">
                            <span class="sr-only">Working</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

    </form>
</body>
</html>

