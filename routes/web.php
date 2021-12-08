<?php

// Router Instance
$router = new AltoRouter();

client_app_router($router);
admin_system_router($router);

function sessionize_app()
{
    session_start();
    ($_SESSION['id_in_session'] <= 0) ? header('Location: login?log=booted out successfully') : '';
}


function client_app_router($router) {
    // Route for Client System if Exists!
}

function admin_system_router($router) {
    /***************
     * GET Requests
     */
    // admin system login route
    $router->map('GET', '/login', function () {
        require '<div class="">
        <config>
        <div class="env-config">.env-loader.php';
        require './resources/auth/login.php';
    });
}

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else { 
    header('location:' . $_SERVER['HTTP_REFERER'] . '');
    exit();
}
