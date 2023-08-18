<?php
require_once ('Models/Database.php');
require_once('Models/Booking.php');
class BookingDataSet
{

    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Adds an application to the database
    public function addBooking($type, $date, $time, $location, $reg, $otherReq, $userID, $websiteID)
    {

        $sqlQuery = "INSERT INTO bookings(Type, Date, Time, Location, Registration, OtherRequirements, UserID, WebsiteID) VALUES ('" . $type . "','" . $date . "','" . $time . "','" . $location . "','" . $reg . "','" . $otherReq . "'," . (int)$userID . "," . (int)$websiteID . ")";
        //$sqlQuery2 = "INSERT INTO Booking(ProjectName, Description, MinRange, MaxRange, Deadline, OtherRequirements, UserID) VALUES ('Proj Test','Desc Test','Range Test','Max Test','Dead Test','Other Test',11)";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //$statement2 = $this->_dbHandle->prepare($sqlQuery2);
        //$statement2->execute();
    }

    //Retrieves all of the applications from a given user
    public function getApplication($userID)
    {
        $sqlQuery = "SELECT * FROM Booking WHERE UserID = $userID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function fetchUserBookings($userId)
    {
        $sqlQuery = 'SELECT * FROM bookings WHERE UserID=' . $userId;

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $book = new Booking($row);
            $dataSet[] = $book;
        }
        return $dataSet;
    }

    public function fetchBookings($date, $location)
    {
        $sqlQuery = 'SELECT * FROM bookings WHERE Date="' . $date . '" AND Location="'.$location.'" ORDER BY Time';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $book = new Booking($row);
            $dataSet[] = $book;
        }
        return $dataSet;
    }

    public function fetchBookingsAllLocations($date, $location1, $location2)
    {
        $sqlQuery = 'SELECT * FROM bookings WHERE Date="' . $date . '" AND Location IN ("' . $location1 . '","' . $location2 . '") ORDER BY Time';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $book = new Booking($row);
            $dataSet[] = $book;
        }
        return $dataSet;
    }

    public function fetchAllBookings($location1, $location2)
    {
        $sqlQuery = 'SELECT * FROM bookings WHERE Location IN ("' . $location1 . '","' . $location2 . '") ORDER BY Time';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $book = new Booking($row);
            $dataSet[] = $book;
        }
        return $dataSet;
    }

    public function fetchTimes($date, $location)
    {
        $sqlQuery = 'SELECT Time FROM bookings WHERE Date="' . $date . '" AND Location="'.$location.'" ORDER BY Time';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row = $statement->fetch();

        return $row;

    }

    public function deleteBooking($id)
    {
        $sqlQuery = 'DELETE FROM bookings WHERE BookingID = '.$id;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}
