<?php

require_once('Models/WebsiteDataSet.php');
$view = new stdClass();
$view->pageTitle = 'Homepage';

session_start();
unset($_SESSION['currentWebsite']);
unset($_SESSION['currentWebsiteLocation']);
unset($_SESSION['currentWebsiteHours']);
unset($_SESSION['web-websiteId']);
unset($_SESSION['name']);
unset($_SESSION['web-email']);
unset($_SESSION['web-number']);
unset($_SESSION['web-address']);
$_SESSION['web-primary'] = '#000000';
$_SESSION['web-secondary'] = '#3a3aa4';
$_SESSION['web-logo'] = 'car-logo.png';
unset($_SESSION['web-image']);
unset($_SESSION['web-text']);
unset($_SESSION["loggedin"]);
unset($_SESSION["userid"]);
unset($_SESSION["admin"]);
unset($_SESSION["changed"]);

$websiteData = new WebsiteDataSet();

//LOCAL
//$url = 'http://' . $_SERVER['SERVER_NAME'] .'/'.  $_SERVER['REQUEST_URI'];
//$websiteName = ltrim($_SERVER['REQUEST_URI'], '/');
//$linkName = str_replace("_", " ", $websiteName);

//HOSTED
$url = 'http://' . $_SERVER['SERVER_NAME'] .''.  $_SERVER['REQUEST_URI'];
$websiteName = ltrim($_SERVER['REQUEST_URI'], '/masters2/index.php/');
$linkName = str_replace("_", " ", $websiteName);

//echo $websiteName;
//echo $linkName;

$currentWebsite = $websiteData->fetchWebsite($linkName);

if($currentWebsite != null)
{
    $_SESSION['currentWebsiteLocation'] = $websiteData->fetchLocations($currentWebsite->getWebsiteID());
    $_SESSION['currentWebsiteHours'] = $websiteData->fetchHours($currentWebsite->getWebsiteID());
    $_SESSION['currentWebsite'] = $currentWebsite;
    //echo $currentWebsite->getName();

    // LOCAL
    //header('Location: index2.php');
    // HOSTED
    header('Location: http://mattfard.com/masters2/index2.php');
}

// HOSTED
else if ($websiteName != null) {
    header('Location: http://mattfard.com/masters2/index.php');
}

unset($_SESSION['adminId']);

require_once('Views/index.phtml');
?>
