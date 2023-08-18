<?php

require('Models/Hours.php');

$view = new stdClass();
$view->pageTitle = 'Contact';

session_start();

if(isset($_POST['submit'])){

    $contactName = $_POST['contact-name'];
    $contactPhone = $_POST['contact-phone'];
    $contactEmail = $_POST['contact-email'];
    $contactSubject = $_POST['contact-subject'];
    $contactMessage = $_POST['contact-message'];

    //Recipient of the email
    $to = $_SESSION['web-email'];

    //Sets the Subject of the email
    $subject = $contactSubject;

    //The body of the message
    $message = '<p><b> Subject:'. $contactSubject .'</b></p> <p> <b>Contact Information:</b>  </p>  <p> Customer Name:'.$contactName.'</p> <p> Phone: '. $contactPhone . '</p> <p> Email: '. $contactEmail .'</p> <p> Message: ' . $contactMessage . '</p>';

    //Headers of the message
    $headers = "From: " . $contactName . "<".$contactEmail.">\r\n";
    $headers .=  "Reply-To: " . $contactName . "<".$contactEmail.">\r\n";
    $headers .="Content-type: text/html\r\n";

    //Sends the mail
    mail($to,$subject,$message, $headers);
}

require_once('Views/contact.phtml');
?>