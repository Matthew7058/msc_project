<?php
class Website
{

    protected $_webID, $_name, $_email, $_phone, $_address, $_primary, $_secondary, $_logo, $_main, $_text;

    //Constructor of Applications from the database
    public function __construct($dbRow)
    {
        $this->_webID = $dbRow['WebsiteID'];
        $this->_name = $dbRow['Name'];
        $this->_email = $dbRow['Email'];
        $this->_phone = $dbRow['Phone'];
        $this->_address = $dbRow['Address'];
        $this->_primary = $dbRow['PrimaryColor'];
        $this->_secondary = $dbRow['SecondaryColor'];
        $this->_logo = $dbRow['LogoImage'];
        $this->_main = $dbRow['MainImage'];
        $this->_text = $dbRow['Text'];
    }
    
    public function getWebsiteID(){
        return $this->_webID;
    }
    public function getName(){
        return $this->_name;
    }

    public function getEmail(){
        return $this->_email;
    }

    public function getPhone(){
        return $this->_phone;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function getPrimaryColor(){
        return $this->_primary;
    }
    public function getSecondaryColor(){
        return $this->_secondary;
    }
    public function getLogoImage(){
        return $this->_logo;
    }
    public function getMainImage(){
        return $this->_main;
    }

    public function getText(){
        return $this->_text;
    }
}
