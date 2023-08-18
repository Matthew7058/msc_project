<?php

$view = new stdClass();
$view->pageTitle = 'Form';

require_once('Models/WebsiteDataSet.php');

session_start();

unset($_SESSION['booked']);

$closedDays[] = null;
//$closedDays = "";
foreach ($_SESSION['currentWebsiteHours'] as $hours)
{
    if($hours->getOpeningTime()==25)
    {
        if($hours->getDay()>6)
        {
            $closedDays[] = 0;
        }
        else{
            $closedDays[] = $hours->getDay();
        }
    }
}
//echo $closedDays[0] . $closedDays[1];
//$newClosedDays  = rtrim($closedDays, ", ");
//echo $newClosedDays;



require_once('Views/form.phtml');
?>