<?php
class Booking
{

    protected $_bookID, $_type, $_date, $_time, $_location, $_reg, $_otherReq, $_userID;

    //Constructor of Applications from the database
    public function __construct($dbRow)
    {
        $this->_bookID = $dbRow['BookingID'];
        $this->_type = $dbRow['Type'];
        $this->_date = $dbRow['Date'];
        $this->_time = $dbRow['Time'];
        $this->_location = $dbRow['Location'];
        $this-> _reg = $dbRow['Registration'];
        $this->_otherReq = $dbRow['OtherRequirements'];
        $this->_userID = $dbRow['UserID'];
    }
    
    public function getBookingID(){
        return $this->_bookID;
    }
    public function getType(){
        return $this->_type;
    }

    public function getDate(){
        return $this->_date;
    }

    public function getTime(){
        return $this->_time;
    }

    public function setTime($time)
    {
        $this->_time = $time;
    }

    public function getLocation(){
        return $this->_location;
    }
    public function getVehicle(){
        return $this->_reg;
    }
    public function getOtherReq(){
        return $this->_otherReq;
    }
    public function getUserID(){
        return $this->_userID;
    }
}
