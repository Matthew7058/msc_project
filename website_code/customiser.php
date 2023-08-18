<?php

require_once('Models/UserDataSet.php');
require_once('Models/WebsiteDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Customiser';

$userDataSet = new UserDataSet();
$websiteData = new WebsiteDataSet();

function roundToNextHour($time) {
    $dateTime = DateTime::createFromFormat('H:i', $time);
    $minutes = (int)$dateTime->format('i');

    // If minutes are more than 0, add an hour
    if ($minutes > 0) {
        $dateTime->add(new DateInterval('PT1H'));
    }

    // Return the hour as an integer
    return (int)$dateTime->format('G');
}

if(isset($_POST['step2']))
{
    // STEP 1 SUBMISSION
    if(isset($_SESSION['adminId']))
    {
        $userId=$_SESSION['adminId'];
    }
    else {
        $userId=59;
    }

    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $number = htmlentities($_POST['number']);
    $address = htmlentities($_POST['address']);

    if(isset($_POST['number1']))
    {
        $number1 = htmlentities($_POST['number1']);
    }
    else {
        $number1 = '0000 000 0000';
    }

    if(isset($_POST['address1']))
    {
        $address1 = htmlentities($_POST['address1']);
    }
    else{
        $address1 = "123 Fake Street";
    }

    $websiteData->addWebsiteDetails($name,$email,$number);
    $websiteId = $websiteData->fetchWebsiteId($email);
    $websiteData->addLocations($address, $websiteId);
    $_SESSION['web-name'] = $name;

    if(isset($_POST['address1']))
    {
        $websiteData->addLocations($address1, $websiteId);
    }

    $_SESSION['websiteId'] = $websiteId;
    $userDataSet->assignWebsite($userId,$websiteId);
    $_SESSION['websiteName'] = $name;
    $_SESSION['websiteEmail'] = $email;

    // STEP 2 SUBMISSION

    $monOpen = 25;
    $monClose = 25;
    $tueOpen = 25;
    $tueClose = 25;
    $wedOpen = 25;
    $wedClose = 25;
    $thursOpen = 25;
    $thursClose = 25;
    $friOpen = 25;
    $friClose = 25;
    $satOpen = 25;
    $satClose = 25;
    $sunOpen = 25;
    $sunClose = 25;

    if(isset($_POST['mon-open']))
    {
        $monOpen = htmlentities($_POST['mon-open']);
        $monOpen = roundToNextHour($monOpen);
    }
    if(isset($_POST['mon-close']))
    {
        $monClose = htmlentities($_POST['mon-close']);
        $monClose = roundToNextHour($monClose);
    }
    if(isset($_POST['tue-open']))
    {
        $tueOpen = htmlentities($_POST['tue-open']);
        $tueOpen = roundToNextHour($tueOpen);
    }
    if(isset($_POST['tue-close']))
    {
        $tueClose = htmlentities($_POST['tue-close']);
        $tueClose = roundToNextHour($tueClose);
    }
    // Code for Wednesday
    if(isset($_POST['wed-open']))
    {
        $wedOpen = htmlentities($_POST['wed-open']);
        $wedOpen = roundToNextHour($wedOpen);
    }
    if(isset($_POST['wed-close']))
    {
        $wedClose = htmlentities($_POST['wed-close']);
        $wedClose = roundToNextHour($wedClose);
    }

    // Code for Thursday
    if(isset($_POST['thurs-open']))
    {
        $thursOpen = htmlentities($_POST['thurs-open']);
        $thursOpen = roundToNextHour($thursOpen);
    }
    if(isset($_POST['thurs-close']))
    {
        $thursClose = htmlentities($_POST['thurs-close']);
        $thursClose = roundToNextHour($thursClose);
    }

    // Code for Friday
    if(isset($_POST['fri-open']))
    {
        $friOpen = htmlentities($_POST['fri-open']);
        $friOpen = roundToNextHour($friOpen);
    }
    if(isset($_POST['fri-close']))
    {
        $friClose = htmlentities($_POST['fri-close']);
        $friClose = roundToNextHour($friClose);
    }

    // Code for Saturday
    if(isset($_POST['sat-open']))
    {
        $satOpen = htmlentities($_POST['sat-open']);
        $satOpen = roundToNextHour($satOpen);
    }
    if(isset($_POST['sat-close']))
    {
        $satClose = htmlentities($_POST['sat-close']);
        $satClose = roundToNextHour($satClose);
    }

    // Code for Sunday
    if(isset($_POST['sun-open']))
    {
        $sunOpen = htmlentities($_POST['sun-open']);
        $sunOpen = roundToNextHour($sunOpen);
    }
    if(isset($_POST['sun-close']))
    {
        $sunClose = htmlentities($_POST['sun-close']);
        $sunClose = roundToNextHour($sunClose);
    }

    $websiteData->addOpeningTimes(1,$monOpen,$monClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(2,$tueOpen,$tueClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(3,$wedOpen,$wedClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(4,$thursOpen,$thursClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(5,$friOpen,$friClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(6,$satOpen,$satClose,$_SESSION['websiteId']);
    $websiteData->addOpeningTimes(7,$sunOpen,$sunClose,$_SESSION['websiteId']);
}

require_once('Views/customiser.phtml');
?>