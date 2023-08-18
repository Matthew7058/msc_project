<?php

$view = new stdClass();
$view->pageTitle = 'History';

require_once("Models/BookingDataSet.php");

session_start();
$applicationData = new BookingDataSet();

if (isset($_SESSION["loggedin"]))
{
    $view->applicationData = $applicationData->fetchUserBookings($_SESSION["userid"]);
}

if (isset($_POST["cancel"]))
{
    $applicationData->deleteBooking($_POST["id"]);
}

require_once('Views/history.phtml');
?>