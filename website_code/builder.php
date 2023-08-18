<?php

require_once('Models/UserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Builder';

session_start();

$userData = new UserDataSet();

if(isset($_POST['step1']))
{
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password1']);

    $encryptedPass = null;

    $encryptedPass= password_hash($password,PASSWORD_DEFAULT);
    $userData->adminRegister($name, $email, $encryptedPass);

    $_SESSION['adminId'] = $userData->fetchId($email);
}

require_once('Views/builder.phtml');
?>