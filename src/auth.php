<?php
    define('ROOT', $_SERVER['DOCUMENT_ROOT']);
    define('SITE_DIR', str_replace(ROOT, '', dirname(__DIR__)));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Authorization</title>
        <meta charset="utf-8">
        <meta name="description" content="Authorization" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="<?=SITE_DIR?>/css/theme.css">
    </head>

    <body>

        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-6 mx-auto">
                    <h1>Salut!</h1>
                    <p>Please enter your login and password:</p>
                    <form id="authorizationForm">
                        <p class="text-danger" id="fieldMsg"></p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="adLog" placeholder="Login" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="password" class="form-control" id="adPass" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="SingIn">Sign in</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
        <script src="<?=SITE_DIR?>js/formAuthHandler.js"></script>
    </body>
</html>