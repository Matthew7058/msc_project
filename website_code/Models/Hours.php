<?php
class Hours
{

    protected $_openID, $_day, $_open, $_close, $_webID;

    //Constructor of Applications from the database
    public function __construct($dbRow)
    {
        $this->_openID = $dbRow['OpeningTimesID'];
        $this->_day = $dbRow['Day'];
        $this->_open = $dbRow['OpeningTime'];
        $this->_close = $dbRow['ClosingTime'];
        $this->_webID = $dbRow['WebsiteID'];
    }

    public function getOpeningTimesID(){
        return $this->_openID;
    }

    public function getDay(){
        return $this->_day;
    }

    public function getOpeningTime(){
        return $this->_open;
    }

    public function getClosingTime()
    {
        return $this->_close;
    }

    public function getWebsiteID(){
        return $this->_webID;
    }
}
