<?php

require_once('Models/WebsiteDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Homepage';

session_start();

$currentWebsite = $_SESSION['currentWebsite'];
//echo $_SESSION['currentWebsiteLocation'][0][1] . $_SESSION['currentWebsiteLocation'][1][1];
//echo $_SESSION['currentWebsiteHours'][0]->getOpeningTime();

if(isset($_SESSION['changed']))
{

}
else {
    $_SESSION['web-websiteId'] = $currentWebsite->getWebsiteID();
    $_SESSION['web-name'] = $currentWebsite->getName();
    $_SESSION['web-email'] = $currentWebsite->getEmail();
    $_SESSION['web-number'] = $currentWebsite->getPhone();
    $_SESSION['web-address'] = $currentWebsite->getAddress();
    $_SESSION['web-primary'] = $currentWebsite->getPrimaryColor();
    $_SESSION['web-secondary'] = $currentWebsite->getSecondaryColor();
    $_SESSION['web-logo'] = $currentWebsite->getLogoImage();
    $_SESSION['web-image'] = $currentWebsite->getMainImage();
    $_SESSION['web-text'] = $currentWebsite->getText();
}

require_once('Views/index2.phtml');
?>