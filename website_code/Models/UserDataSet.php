<?php
require_once ('Models/Database.php');
require_once ('Models/User.php');
session_start();
class UserDataSet
{

    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function addUser($name, $email, $number, $address, $website)
    {
        $sqlQuery = "INSERT INTO users(Name, Email, Phone, Address, WebsiteID) VALUES ('" . $name . "','" . $email . "','" . $number . "','" . $address . "'," . $website . ")";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function register($name, $email, $number, $address, $password, $website)
    {
        $sqlQuery = "INSERT INTO users(Name, Email, Phone, Address, Password, WebsiteID) VALUES ('" . $name . "','" . $email . "','" . $number . "','" . $address . "','" . $password . "'," . $website . ")";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function adminRegister($name, $email, $password)
    {
        $sqlQuery = "INSERT INTO users(Name, Email, Phone, Address, Password, admin) VALUES ('" . $name . "','" . $email . "', null, null,'" . $password . "',1 )";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function assignWebsite($userId, $websiteId)
    {
        $sqlQuery = "UPDATE users SET WebsiteID = " . $websiteId ." WHERE UserID = ". $userId;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function fetchPassword($email)
    {
        $sqlQuery = "SELECT Password FROM users WHERE Email='" . $email . "'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $row = $statement->fetch();

        if ($row != null) {
            return $row[0];
        }
        else {
            return null;
        }
    }

    public function fetchId($email)
    {
        $sqlQuery = "SELECT UserID FROM users WHERE Email='".$email."'";
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

    public function fetchAdmin($email)
    {
        $sqlQuery = "SELECT admin FROM users WHERE Email='".$email."'";
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

    public function fetchWebsite($email)
    {
        $sqlQuery = "SELECT WebsiteID FROM users WHERE Email='".$email."'";
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

    public function uniqueEmailCheck($email)
    {
        $sqlQuery = "SELECT Email FROM users";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $row=$statement->fetch();
        $count = 0;
        $found = false;
        while($count< count($row) && !$found) {

            if ($row[$count] = $email)
            {
                $found = true;
            }

            else{
                $count = $count +1;
            }
        }
        return $found;
    }

    public function fetchUser($userID)
    {
        $sqlQuery = 'SELECT Name, Email, Phone, Address FROM users WHERE UserID = '.$userID;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row=$statement->fetch();


        $_SESSION["na"] = $row[0];
        $_SESSION["em"] = $row[1];
        $_SESSION["pho"] = $row[2];
        $_SESSION["add"] = $row[3];


        return $row;
    }

    public function fetchUserAdmin($userID)
    {
        $sqlQuery = 'SELECT Name, Email, Phone, Address FROM users WHERE UserID = '.$userID;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row=$statement->fetch();


        $_SESSION["user-name"] = $row[0];
        $_SESSION["user-email"] = $row[1];
        $_SESSION["user-phone"] = $row[2];
        $_SESSION["user-address"] = $row[3];
    }


    public function getCustomerName($userID)
    {
        $sqlQuery = 'SELECT Name FROM users WHERE UserID = '.$userID;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $row = $statement->fetch();

        if ($row != null) {
            return $row[0];
        } else {
            return null;
        }
    }

    public function deleteUser($userID)
    {
        $sqlQuery1 = 'UPDATE bookings SET UserID=13 WHERE UserID='.$userID;
        $statement1 = $this->_dbHandle->prepare($sqlQuery1);
        $statement1->execute();
        $sqlQuery = 'DELETE FROM users WHERE UserID = '.$userID;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeName($id, $newName)
    {
        $sqlQuery = "UPDATE users SET Name = '" . $newName . "' WHERE UserID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeEmail($id, $newEmail)
    {
        $sqlQuery = "UPDATE users SET Email = '" . $newEmail . "' WHERE UserID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeNumber($id, $newNumber)
    {
        $sqlQuery = "UPDATE users SET Phone = '" . $newNumber . "' WHERE UserID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changeAddress($id, $newAddress)
    {
        $sqlQuery = "UPDATE users SET Address = '" . $newAddress . "' WHERE UserID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function changePassword($id, $newPassword)
    {
        $sqlQuery = "UPDATE users SET Password = '" . $newPassword . "' WHERE UserID = ".$id ;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}
