<?php
require_once ('Models/Database.php');
require_once('Models/Website.php');
require_once('Models/Hours.php');
class WebsiteDataSet
{

    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Adds an application to the database
    public function addWebsite($name, $email, $phone, $address, $primaryColour, $secondaryColour, $logo, $image, $text)
    {
        $sqlQuery = "INSERT INTO websites(Name, Email, Phone, Address, PrimaryColor, SecondaryColor, LogoImage, MainImage, Text) VALUES ('" . $name . "','" . $email . "','" . $phone . "','" . $address . "','" . $primaryColour . "','" . $secondaryColour . "','" . $logo . "','" . $image . "','" . $text . "')";
        //$sqlQuery2 = "INSERT INTO Booking(ProjectName, Description, MinRange, MaxRange, Deadline, OtherRequirements, UserID) VALUES ('Proj Test','Desc Test','Range Test','Max Test','Dead Test','Other Test',11)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //$statement2 = $this->_dbHandle->prepare($sqlQuery2);
        //$statement2->execute();
    }

    public function addWebsiteDetails($name, $email, $phone)
    {

        $sqlQuery = "INSERT INTO websites(Name, Email, Phone) VALUES ('" . $name . "','" . $email . "','" . $phone . "')";
        //$sqlQuery2 = "INSERT INTO Booking(ProjectName, Description, MinRange, MaxRange, Deadline, OtherRequirements, UserID) VALUES ('Proj Test','Desc Test','Range Test','Max Test','Dead Test','Other Test',11)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //$statement2 = $this->_dbHandle->prepare($sqlQuery2);
        //$statement2->execute();
    }

    public function fetchWebsiteId($email)
    {
        $sqlQuery = "SELECT WebsiteID FROM websites WHERE Email='".$email."'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $row=$statement->fetch();

        if ($row != null)
        {
            return $row[0];
        }

        else
        {
            return null;
        }
    }

    public function addLocations($location, $website)
    {
        $sqlQuery = "INSERT INTO locations(Address, WebsiteID) VALUES ('" . $location . "'," . $website . ")";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function addOpeningTimes($day, $opening, $closing, $website)
    {

        $sqlQuery = "INSERT INTO times(Day, OpeningTime, ClosingTime, WebsiteID) VALUES (" . $day . "," . $opening . "," . $closing . "," . $website . ")";
        //$sqlQuery2 = "INSERT INTO Booking(ProjectName, Description, MinRange, MaxRange, Deadline, OtherRequirements, UserID) VALUES ('Proj Test','Desc Test','Range Test','Max Test','Dead Test','Other Test',11)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //$statement2 = $this->_dbHandle->prepare($sqlQuery2);
        //$statement2->execute();
    }

    public function addColours($primaryColour, $secondaryColour, $website)
    {

        $sqlQuery = "UPDATE websites SET PrimaryColor = '" . (string)$primaryColour ."' WHERE WebsiteID = ". $website;
        $sqlQuery2 = "UPDATE websites SET SecondaryColor = '" . (string)$secondaryColour ."' WHERE WebsiteID = ". $website;

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $statement2 = $this->_dbHandle->prepare($sqlQuery2);
        $statement2->execute();
    }

    public function addImages($logo, $image, $website)
    {

        $sqlQuery = "UPDATE websites SET LogoImage = '" . $logo ."' WHERE WebsiteID = ". $website;
        $sqlQuery2 = "UPDATE websites SET MainImage = '" . $image ."' WHERE WebsiteID = ". $website;

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $statement2 = $this->_dbHandle->prepare($sqlQuery2);
        $statement2->execute();
    }

    public function addText($text, $website)
    {

        $sqlQuery = "UPDATE websites SET Text = '" . $text ."' WHERE WebsiteID = ". $website;

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function fetchWebsite($name)
    {
        $sqlQuery = 'SELECT * FROM websites WHERE Name="' . $name . '"';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $site = new Website($row);
            $dataSet[] = $site;
        }
        return $dataSet[0];
    }

    public function fetchHours($website)
    {
        $sqlQuery = 'SELECT * FROM times WHERE WebsiteID=' . $website;

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $hours = new Hours($row);
            $dataSet[] = $hours;
        }
        return $dataSet;
    }

    public function fetchLocations($website)
    {
        $sqlQuery = "SELECT * FROM locations WHERE WebsiteID=" . $website;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        //$row=$statement->fetch();
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = $row;
        }
        return $dataSet;
    }

    public function changeWebsiteName($id, $newName)
    {
        $sqlQuery = "UPDATE websites SET Name = '" . $newName . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeWebsiteEmail($id, $newEmail)
    {
        $sqlQuery = "UPDATE websites SET Email = '" . $newEmail . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeWebsiteNumber($id, $newNumber)
    {
        $sqlQuery = "UPDATE websites SET Phone = '" . $newNumber . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeWebsiteAddress($id, $newAddress)
    {
        $sqlQuery = "UPDATE locations SET Address = '" . $newAddress . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeOpeningTimes($day, $newOpening, $newClosing, $website)
    {

        $sqlQuery = "UPDATE times SET OPENING = '" . $newOpening . "', CLOSING = '".$newClosing."' WHERE WebsiteID = ".$website." AND Day = ".$day;
        //$sqlQuery2 = "INSERT INTO Booking(ProjectName, Description, MinRange, MaxRange, Deadline, OtherRequirements, UserID) VALUES ('Proj Test','Desc Test','Range Test','Max Test','Dead Test','Other Test',11)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //$statement2 = $this->_dbHandle->prepare($sqlQuery2);
        //$statement2->execute();
    }

    public function changePrimaryColour($id, $newPrimary)
    {
        $sqlQuery = "UPDATE websites SET PrimaryColour = '" . $newPrimary . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeSecondaryColour($id, $newSecondary)
    {
        $sqlQuery = "UPDATE websites SET SecondaryColour = '" . $newSecondary . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeLogo($id, $newLogo)
    {
        $sqlQuery = "UPDATE websites SET LogoImage = '" . $newLogo . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeImage($id, $newImage)
    {
        $sqlQuery = "UPDATE websites SET MainImage = '" . $newImage . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeText($id, $text)
    {
        $sqlQuery = "UPDATE websites SET Text = '" . $text . "' WHERE WebsiteID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}
