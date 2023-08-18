<?php

require_once("Models/BookingDataSet.php");
require_once("Models/UserDataSet.php");

$view = new stdClass();
$view->pageTitle = 'timetable';
session_start();

$userData = new UserDataSet();
$bookingData = new BookingDataSet();

$date = date('Y-m-d');
$location = "select";

$view->allBookingData = $bookingData->fetchAllBookings($_SESSION["currentWebsiteLocation"][0][1], $_SESSION["currentWebsiteLocation"][1][1]);

$view->dates = [];
$view->times = [];
$view->names = [];
$view->email = [];
$view->phone = [];
$view->address = [];
$view->locations = [];
$view->ids = [];

foreach($view->allBookingData as $booking) {
    $view->dates[] = $booking->getDate();
}
foreach($view->allBookingData as $booking) {
    $view->times[] = $booking->getTime();
}

foreach($view->allBookingData as $booking) {
    $view->ids[] = $booking->getBookingID();
}

foreach($view->allBookingData as $booking) {
    $user = $userData->fetchUserAdmin($booking->getUserID());
    $view->names[] = $_SESSION["user-name"];
    $view->email[] = $_SESSION["user-email"];
    $view->phone[] = $_SESSION["user-phone"];
    $view->address[] = $_SESSION["user-address"];
}

foreach($view->allBookingData as $booking) {
    $view->locations[] = $booking->getLocation();
}

if(isset($_POST["find"]))
{
    $location = $_POST['location'];
    $date = $_POST['date'];
    if ($location == "select")
    {
        $view->bookingData = $bookingData->fetchBookingsAllLocations($date, $_SESSION["currentWebsiteLocation"][0][1], $_SESSION["currentWebsiteLocation"][1][1]);
        $view->date = "Bookings on ".$date." at all locations";
    }

    else
    {
        $view->bookingData = $bookingData->fetchBookings($date, $location);
        $view->date = "Bookings on ".$date." at " .$location;
    }
}

if (isset($_POST["delete-booking"]))
{
    $bookingData->deleteBooking((int)$_POST["bookId"]);
}


$date3 = date('Y-m-d');
$location3 = "select";

if(isset($_POST["find"]))
{
    $location3 = $_POST['location'];
    $date3 = $_POST['date'];
    if ($location3 == "select")
    {
        $view->bookingData = $bookingData->fetchBookingsAllLocations($date3, $_SESSION["currentWebsiteLocation"][0][1], $_SESSION["currentWebsiteLocation"][1][1]);
        $view->date = "Bookings on ".$date3." at all locations";
    }

    else
    {
        $view->bookingData = $bookingData->fetchBookings($date3, $location3);
        $view->date = "Bookings on ".$date3." at " .$location3;
    }
}

if (isset($_POST["cancel"]))
{
    $bookingData->deleteBooking($_POST["id"]);
}

require_once('Views/timetable.phtml');
?>