<?php
    require_once '/root/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $dark_theme = False;
    if (isset($_COOKIE["dark_theme"])) {
        $dark_theme = True;
    }

    echo $twig->render('fact.html', ['dark_theme' => $dark_theme]);
?>
