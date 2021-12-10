<?php

// Router Instance
$router = new AltoRouter();

client_app_router($router);
admin_system_router($router);

function sessionize_app()
{
    session_start();
    ($_SESSION['id_in_session'] <= 0) ? header('Location: /?log=booted out successfully') : '';
}


function client_app_router($router) {
    // Route for Client System if Exists!
}

function admin_system_router($router) {
    /***************
     * GET Requests
     */
    // admin system login route
    $router->map('GET', '/', function () {
        require './config/.env-config/.env-loader.php';
        require './resources/auth/login.php';
    });

    $router->map('GET', '/register', function () {
        require './config/.env-config/.env-loader.php';
        require './resources/auth/register.php';
    });

    $router->map('GET', '/dashboard', function () {
        sessionize_app();
        require './config/.env-config/.env-loader.php';
        require './resources/views/dashboard.php';
    });

    $router->map('POST', '/login', function () { 
        require './config/.env-config/.env-loader.php';
        require './app/http/auth/AuthController.php';
        require './config/database/database_connection.php';

        $connection = new Database($database_host, $database_name, $database_username, $database_password);
        $connection = $connection->getConnection();

        $email = (isset($_POST['email'])) ? $_POST['email'] : NULL;
        $password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

        $User = new Auth($connection, $email, $password);
        $User->login();
    });

    $router->map('POST', '/register', function () {
        require './config/.env-config/.env-loader.php';
        require './app/http/auth/AuthController.php';
        require './config/database/database_connection.php';

        $connection = new Database($database_host, $database_name, $database_username, $database_password);
        $connection = $connection->getConnection();

        $username = (isset($_POST['username'])) ? $_POST['username'] : NULL;
        $email = (isset($_POST['email'])) ? $_POST['email'] : NULL;
        $password = (isset($_POST['password'])) ? $_POST['password'] : NULL;
        $confirmation_password = (isset($_POST['cpassword'])) ? $_POST['cpassword'] : NULL;

        $User = new Auth($connection, $email, $password);
        $User->register($username, $confirmation_password);
    });

    $router->map('GET', '/logout', function () {
        require './config/.env-config/.env-loader.php';
        require './app/http/auth/AuthController.php';
        require './config/database/database_connection.php';

        $connection = new Database($database_host, $database_name, $database_username, $database_password);
        $connection = $connection->getConnection();

        $email = (isset($_POST['email'])) ? $_POST['email'] : NULL;
        $password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

        $User = new Auth($connection, $email, $password);
        $User->logout();
        sessionize_app();
    });

    $router->map('POST', '/set-product-entity', function () {
        require './config/.env-config/.env-loader.php';
        require './app/http/controllers/ProductController.php';
        require './config/database/database_connection.php';
        session_start();
        $connection = new Database($database_host, $database_name, $database_username, $database_password);
        $connection = $connection->getConnection();

        $product_link = (isset($_POST['product_link'])) ? $_POST['product_link'] : NULL;
        $product_current_price = (isset($_POST['product_current_price'])) ? $_POST['product_current_price'] : NULL;
        $user_in_session = $_SESSION['id_in_session'] ? $_SESSION['id_in_session'] : NULL; 

        $User = new Product($connection, $product_link, $product_current_price);
        $User->set_item_entities($user_in_session);
    });

}

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else { 
    header('location:' . $_SERVER['HTTP_REFERER'] . '');
    exit();
}
