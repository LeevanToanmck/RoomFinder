<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dripped Stonie</title>
    <link rel="stylesheet" href="./../public/css/menu1.css">
    <link rel="stylesheet" href="./../public/css/posts.css">
</head>
<style>
    body{
        padding: 0;
        
    }
    </style>

<body>
    <div id="wrapper">
        <!--Phần đầu-->
        <?php include "./../views/client/include/menu.php"; ?>
        <!--Phần thân-->
        <?php
        if (isset($content) && !empty($content)) {
            echo $content;
        } else {
            include "./../views/client/include/banner.php";
            // include "./../views/client/include/main.php";
        }
        ?>
        <!--Phần cuối-->
        <?php include "./../views/client/include/footer.php"; ?>
    </div>

</body>
</html>