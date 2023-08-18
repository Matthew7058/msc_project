<?php
$view = new stdClass();
$view->pageTitle = 'Profile';

require_once('Models/UserDataSet.php');
require_once('Models/WebsiteDataSet.php');


$view->profileError = null;

$view->profileErrorTemplate = '<div class="text-block">'.$view->profileError.'</div>';

$userData = new UserDataSet();
$websiteData = new WebsiteDataSet();

$id = $_SESSION["userid"];
//echo $id;
$view->name = $_SESSION["na"];
$view->email = $_SESSION["em"];
$view->phoneNo = $_SESSION["pho"];
$view->address = $_SESSION["add"];

if(isset($_POST['delete']))
{
    // IF ADMIN
    // DELETE LOCATIONS
    // DELETE OPENING HOURS
    // DELETE WEBSITE
    // DELETE USER
    // SESSION.DESTROY
    // HEADER: index.php

    // ELSE
    // DELETE USER
    // HEADER: index2.php
    $userData->deleteUser($id);
    unset($_SESSION["loggedin"]);
    unset($_SESSION["userid"]);
    header("Location: index2.php");
    session_destroy();
}

if(isset($_POST['save']))
{
    if(isset($_POST['customer-name']))
    {
        $userData->changeName($_SESSION['userid'],$_POST['customer-name']);
    }
    if(isset($_POST['customer-email']))
    {
        $userData->changeEmail($_SESSION['userid'],$_POST['customer-email']);
    }
    if(isset($_POST['customer-phone']))
    {
        $userData->changeNumber($_SESSION['userid'],$_POST['customer-phone']);
    }
    if(isset($_POST['customer-add1']))
    {
        $userData->changeAddress($_SESSION['userid'],$_POST['customer-add1'].", ".$_POST['customer-add2'].", ".$_POST['customer-city'].", ".$_POST['customer-postcode']);
    }
    if(isset($_POST['customer-password']))
    {
        $userData->changePassword($_SESSION['userid'],$_POST['customer-password']);
    }
    if(isset($_POST['web-name']))
    {
        $websiteData->changeWebsiteName($_SESSION['web-websiteId'],$_POST['web-name']);
        $_SESSION['web-name'] = $_POST['web-name'];
    }
    if(isset($_POST['web-email']))
    {
        $websiteData->changeWebsiteEmail($_SESSION['web-websiteId'],$_POST['web-email']);
        $_SESSION['web-email'] = $_POST['web-email'];
    }
    if(isset($_POST['web-phone']))
    {
        $websiteData->changeWebsiteNumber($_SESSION['web-websiteId'],$_POST['web-phone']);
        $_SESSION['web-number'] = $_POST['web-phone'];
    }
    if(isset($_POST['web-address']))
    {
        $websiteData->changeWebsiteAddress($_SESSION['web-websiteId'],$_POST['web-phone']);
        $_SESSION['web-address'] = $_POST['web-address'];
    }
    if(isset($_POST['mon-open']) && isset($_POST['mon-close']))
    {
        $monOpen = htmlentities($_POST['mon-open']);
        $monClose = htmlentities($_POST['mon-close']);
        $websiteData->changeOpeningTimes(1,$monOpen,$monClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['tue-open']) && isset($_POST['tue-close']))
    {
        $tueOpen = htmlentities($_POST['tue-open']);
        $tueClose = htmlentities($_POST['tue-close']);
        $websiteData->changeOpeningTimes(2,$tueOpen,$tueClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['wed-open']) && isset($_POST['wed-close']))
    {
        $wedOpen = htmlentities($_POST['wed-open']);
        $wedClose = htmlentities($_POST['wed-close']);
        $websiteData->changeOpeningTimes(3,$wedOpen,$wedClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['thurs-open']) && isset($_POST['thurs-close']))
    {
        $thursOpen = htmlentities($_POST['thurs-open']);
        $thursClose = htmlentities($_POST['thurs-close']);
        $websiteData->changeOpeningTimes(4,$thursOpen,$thursClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['fri-open']) && isset($_POST['fri-close']))
    {
        $friOpen = htmlentities($_POST['fri-open']);
        $friClose = htmlentities($_POST['fri-close']);
        $websiteData->changeOpeningTimes(5,$friOpen,$friClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['sat-open']) && isset($_POST['sat-close']))
    {
        $satOpen = htmlentities($_POST['sat-open']);
        $satClose = htmlentities($_POST['sat-close']);
        $websiteData->changeOpeningTimes(6,$satOpen,$satClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['sun-open']) && isset($_POST['sun-close']))
    {
        $sunOpen = htmlentities($_POST['sun-open']);
        $sunClose = htmlentities($_POST['sun-close']);
        $websiteData->changeOpeningTimes(7,$sunOpen,$sunClose,$_SESSION['web-websiteId']);
    }
    if(isset($_POST['primary']))
    {
        $websiteData->changePrimaryColour($_SESSION['web-websiteId'],$_POST['primary']);
        $_SESSION['web-primary'] = $_POST['secondary'];
    }
    if(isset($_POST['secondary']))
    {
        $websiteData->changePrimaryColour($_SESSION['web-websiteId'],$_POST['secondary']);
        $_SESSION['web-secondary'] = $_POST['secondary'];
    }
    if(isset($_POST['hidden-logo']))
    {
        $websiteData->changeLogo($_SESSION['web-websiteId'],$_POST['hidden-logo']);
        $_SESSION['web-logo'] = $_POST['hidden-logo'];
    }
    if(isset($_POST['hidden-image']))
    {
        $websiteData->changeImage($_SESSION['web-websiteId'],$_POST['hidden-image']);
        $_SESSION['web-image'] = $_POST['hidden-image'];
    }
    if(isset($_POST['paragraph-text']))
    {
        $websiteData->changeText($_SESSION['web-websiteId'],$_POST['paragraph-text']);
        $_SESSION['web-text'] = $_POST['text'];
    }

    $_SESSION['changed'] = true;
}



require_once('Views/profile.phtml');
?>