<?php

$view = new stdClass();
$view->pageTitle = 'Book';

require_once('Models/Hours.php');
require_once('Models/BookingDataSet.php');
require_once('Models/UserDataSet.php');

$userDataSet = new UserDataSet();
$applicationData = new BookingDataSet();

session_start();

$dayOpening = 0;
$dayClosing = 0;

if($_SESSION['admin'])
{
    $requirement = '(Optional)';
}
else{
    $requirement = '*';
}

if (isset($_POST['check'])) {
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['vehicle'] = $_POST['reg'];
    $_SESSION['other'] = "";
    $_SESSION['chosen-day'] = $_POST['chosen-day'];

    $view->applicationData = $applicationData->fetchBookings($_SESSION['date'], $_SESSION['location']);
    $_SESSION['dayOpening'] = $_SESSION['currentWebsiteHours'][($_SESSION['chosen-day']-1)]->getOpeningTime();
    $_SESSION['dayClosing'] = $_SESSION['currentWebsiteHours'][($_SESSION['chosen-day']-1)]->getClosingTime();
    //echo $_SESSION['dayOpening'];
    //echo $_SESSION['dayClosing'];
}

if(isset($_POST['book']))
{
    $time = $_POST['time'];
    $id=33;

    $email = "";
    $address = "";
    $number = "";

    if(isset($_SESSION["loggedin"]) && !$_SESSION['admin'])
    {
        $id1 = htmlentities($_SESSION["userid"]);
        $id = (int)$id1;
        $userDataSet->fetchUser($id);
        $customerName =  htmlentities($_SESSION["na"]);
        $email = htmlentities($_SESSION["em"]);
        $address = htmlentities($_SESSION["add"]);
        $number = htmlentities($_SESSION["pho"]);
    }

    else {
        $customerName = htmlentities($_POST['customer-name']);
        $email = htmlentities($_POST['email']);
        $number = htmlentities($_POST['number']);
        $address1 = htmlentities($_POST['address1']);
        $address2 = htmlentities($_POST['address2']);
        $city = htmlentities($_POST['city']);
        $postcode = htmlentities($_POST['postcode']);

        $address = $address1 . ', ' . $address2 . ', ' . $city . ', ' . $postcode;
        $userDataSet->addUser($customerName,$email,$number,$address, $_SESSION["web-websiteId"]);
        $id = $userDataSet->fetchId($email);
    }

    $applicationData->addBooking("MOT", $_SESSION['date'], (int)$time, $_SESSION['location'], $_SESSION['vehicle'], $_SESSION['other'], $id, $_SESSION['web-websiteId']);
    $_SESSION['booked'] = true;

    // EMAIL TO THE GARAGE
    $to=$_SESSION['web-email'];
    $message =
        '
        <div class="hero-section">

            <div class="hero-section-right-block mobile-view"></div>
            <div class="hero-section-left-block">
                <h1 class="heading-2">A New Booking Has Been Made</h1>
                <p class="paragraph-2"><b>Customer Name: '.$customerName.'</b></p>
                <p class="paragraph-2"><b>Location: '.$_SESSION["location"].'</b></p>
                <p class="paragraph-2"><b>Date: '.$_SESSION["date"].'</b></p>
                <p class="paragraph-2"><b>Time: '.$time.'</b></p>
                <p class="paragraph-2"><b>Type: MOT</b></p>
                <p class="paragraph-2"></p>
                <p class="paragraph-2">Other Details:</p>
                <p class="paragraph-2">Vehicle: '.$_SESSION["vehicle"].'</p>
                <p class="paragraph-2">Customer Email: '.$email.'</p>
                <p class="paragraph-2">Customer Phone Number: '.$number.'</p>
                <p class="paragraph-2">Customer Address: '.$address.'</p>
            </div>
            <div class="hero-section-right-block"></div>
        </div>';
    $headers = "From: " . $customerName . "<".$email.">\r\n";
    $headers .=  "Reply-To: " . $customerName . "<".$email.">\r\n";
    $headers .="Content-type: text/html\r\n";
    mail($to,"New Booking Alert",$message, $headers);

    // EMAIL TO CUSTOMER
    $to2 = $email;
    $message2 =
        '
            <h1>Thank you '.$customerName.'</h1>
            <p>Your booking has been confirmed!</p>
            <p></p>
            <p><b>Location: '.$_SESSION["location"].'</b></p>
            <p><b>Date: '.$_SESSION["date"].'</b></p>
            <p><b>Time: '.$time.'</b></p>
            <p><b>Type: MOT</b></p>
            <p></p>
            <p>Thank you for choosing '.$_SESSION["web-name"].'. We look forward to seeing you soon for your MOT.</p>
            <p>If you need to amend or cancel your booking please conact us via our website</p>
        ';
    $headers2 = "From: ".$_SESSION['web-name']." <".$_SESSION['web-email'].">\r\n";
    $headers2 .=  "Reply-To: ".$_SESSION['web-name']."<".$_SESSION['web-email'].">\r\n";
    $headers2 .="Content-type: text/html\r\n";
    mail($to2,"Booking Confirmed - ".$_SESSION['web-name'],$message2, $headers2);
}

require_once('Views/book.phtml');
?>