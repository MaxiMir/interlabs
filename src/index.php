<?php

    session_start();

    require_once '../vendor/autoload.php';

    use App\Utils\User;
    use App\PDO\Select;
    use App\Render\HtmlMarkup;

    $isAdmin = User::isAdmin();
    
    if (!$isAdmin) {
        header("Location: auth.php");
    } else {
        $users = new Select('users', ['orderBy' => 'user_pos']);
        $usersData = $users->all();
        
        echo HtmlMarkup::generate('users.twig', ['usersData' => $usersData]);
    }



