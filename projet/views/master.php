<?php
include 'header.php';

$mainStyle=file_get_contents("views/stylesBundle.html");
$mainScript=file_get_contents("views/scriptsBundle.html");
if (!isset($otherScript)) $otherScript = "";

if (!isset($header)) $header = "";
if (!isset($main)) $main = "";
if (!isset($title)) $title = "";


echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chevalresk</title>
        $mainStyle
        $mainScript
        $otherScript
    </head>

    <body>
        <div id="header" class="sticky">
            $header
        </div>
        <div class="main">
            <h1 class="title">$title</h1>
            $main
        </div>
    </body>
    </html>
HTML;