<?php

require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

$database_host = $_ENV['DB_HOST'];
$database_name = $_ENV['DB_NAME'];
$database_username = $_ENV['DB_USERNAME'];
$database_password = $_ENV['DB_PASSWORD'];

$notification_email = $_ENV["MAIL_NOTIFICATION_EMAIL_ADDRESS"];
$notification_email_password = $_ENV['MAIL_NOTIFICATION_PASSWORD'];

