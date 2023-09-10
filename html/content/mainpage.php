<?php
    session_start();
    if(empty($_SESSION['userid']) || $_SESSION['userid']=='') {
        header("location: /iisstart.php");
        die();
    }
?>

<html>
    <head>
        <title>Hello</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="mainpage.style.css">
    </head>
    <body>
        <main>
            <section class="gallery-links">
                <div class="wrapper">
                <div class="gallery-upload">
                    <form enctype="multipart/form-data" action="/content/upload.php" method="POST">
                        <input type="file" name="uploadedfile">
                        <button type="submit" name="submit">Upload</button>
                    </form>
                    <a href="/connect/logoff.php">Logoff</a>
                </div>
            </section>
        </main>
    </body>
</html>
