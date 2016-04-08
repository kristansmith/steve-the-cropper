<?php
session_start();
require_once 'image_manipulation.php';
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Image Manipulation With JQuery and PHP GD</title>
        <script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.2/css/uikit.css" media="screen" title="no title" charset="utf-8">

        <link rel="stylesheet" href="style.css" media="screen">

        <style media="screen">
            #drag_box {
                position:absolute;
                border:solid 1px #333;
                background:rgba(257, 257, 257, .5);
                z-index:10;
            }
        </style>

    </head>

    <body>

        <?php if (!isset($_SESSION['newPath']) || isset($_GET['new'])) { ?>
            <h1>Image Uploader and Manipulator</h1>
            <?php
                if (!empty($error)) {
                    echo '<p class="uk-alert uk-alert-danger">' . $error . '</p>';
                }
                ?>
                <form method="POST" action="index.php" enctype="multipart/form-data">


                    <fieldset class="form-group">
                        <label for="img_upload">Email address</label>
                        <input type="file" name="img_upload" id="img_upload" placeholder="Image to Upload">
                        <small class="text-muted">We'll never share your image with anyone else.</small>
                    </fieldset>


                    <fieldset class="form-group">
                        <label for="img_name">Image Name</label>
                        <input type="text" name="img_name" id="img_name" placeholder="Image Name">
                    </fieldset>

                    <button type="submit" class="btn btn-primary" name="upload_form_submitted">Submit</button>
                </form>

                <?php }
                                    else { ?>
                    <img id="uploaded_image" src="<?php echo $_SESSION['newPath'] .'?'.rand(0, 10000); ?>" />
                    <p>
                        <a href="index.php?new=true">Start over with new image</a>
                    </p>

                    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
                    <script type="text/javascript">
                        google.load("jquery", "1.5");
                    </script>
                    <script type="text/javascript" src="js.js">
                    </script>
                <?php } ?>
        </body>

        </html>
