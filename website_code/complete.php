<?php

require_once('Models/WebsiteDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Complete';

session_start();

$websiteData = new WebsiteDataSet();

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$target_dir1 = "images/";
$target_file1 = $target_dir1 . basename($_FILES["fileToUpload1"]["name"]);
$uploadOk1 = 1;
$imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

if(isset($_POST['step3']))
{
    $primary = htmlentities($_POST['primary']);
    $secondary = htmlentities($_POST['secondary']);

    $websiteData->addColours($primary,$secondary,$_SESSION['websiteId']);

    $_SESSION['primary'] = $primary;
    $_SESSION['secondary'] = $secondary;

    $_SESSION['web-primary'] = $primary;
    $_SESSION['web-secondary'] = $secondary;

    $logo = $_POST['hidden-logo'];
    $image = $_POST['hidden-image'];

    $websiteData->addImages($logo, $image, $_SESSION['websiteId']);

    $text = htmlentities($_POST['paragraphText']);
    $websiteData->addText($text,$_SESSION['websiteId']);

    //Recipient of the email
    $to = $_SESSION['websiteEmail'];

    $message =
        '
        <div class="hero-section">

            <div class="hero-section-right-block mobile-view"></div>
            <div class="hero-section-left-block">
                <h1 class="heading-2">Thank You for creating your website with us</h1>
                <p class="paragraph-2"><b>Your unique link is: '.$url.'</b></p>
            </div>
            <div class="hero-section-right-block"></div>
        </div>';
    $headers = "From: Website Builder for MOT garages <matthewfard@me.com>\r\n";
    $headers .=  "Reply-To: Matthew Fard<matthewfard@me.com>\r\n";
    $headers .="Content-type: text/html\r\n";
    mail($to,"Your Fresh Website",$message, $headers);
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
} else {
    //echo "Sorry, there was an error uploading your file.";
}

if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload1"]["name"])). " has been uploaded.";
} else {
    //echo "Sorry, there was an error uploading your file.";
}

$name = $_SESSION['websiteName'];
$linkName = preg_replace('/\s+/', '_', $name);
//LOCAL
//$url = 'http://' . $_SERVER['SERVER_NAME'] . ':8086/'. $linkName;
//HOSTED
$url = 'http://' . $_SERVER['SERVER_NAME'] . '/masters2/index.php/'. $linkName;

require_once('Views/complete.phtml');
?>