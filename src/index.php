<?php

    session_start();

    require_once '../vendor/autoload.php';

    use App\Utils\Admin;
    use App\PDO\Select;
    use App\Render\HtmlMarkup;

    $isAdmin = Admin::checkOnAdmin();

    if (!$isAdmin) {
        header("Location: auth.php");
    } else {
        $users = new Select('users', ['orderBy' => 'user_pos']);
        $usersData = $users->all();
        print HtmlMarkup::generate('users.twig', ['usersData' => $usersData]);
    }



