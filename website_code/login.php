<?php
require_once('Models/UserDataSet.php');
$view = new stdClass();
$view->pageTitle = 'Login';

//session_start();
$userData= new UserDataSet();
//creates new UserDataSet class

$view->loggedin = "";

$view->resetError = null;

$view->resetErrorTemplate = '<div class="text-block">'.$view->resetError.'</div>';

unset($_SESSION["registered"]);
unset($_SESSION["deleted"]);

/*if (isset($_POST["forgot"]))
{
    $_SESSION['email1'] = $_POST['email'];
    $to = htmlentities($_POST['email']);
    $_SESSION['code1'] = rand ( 1000 , 9999 );
    $code = $_SESSION['code1'];
    $message = '<p>You reset code is '.$code.'</p>';
    $subject = "KRM Password reset code";
    $headers= "From: KRM";
    mail($to,$subject,$message, $headers);
}*/

/*if (isset($_POST["change"]))
{
    $newPassword1 = htmlentities($_POST['passwordR1']);
    $newPassword2 = htmlentities($_POST['passwordR2']);
    $userCode = htmlentities($_POST['reset-code']);
    $id = $userData->fetchId($_SESSION['email1'] );
    if ($userCode = $code) {


        if ($newPassword1 == $newPassword2) {
            $password = $newPassword1;

            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $view->profileError = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';

            } else {
                $encryptedPass = password_hash($password, PASSWORD_DEFAULT);
                $userData->changePassword($id, $encryptedPass);
                $view->resetError = "Thank You! Your password has been changed!";
            }
        } else {
            $view->resetError = "Oops! Your passwords do not match!";
        }
    }

    else{
        $view->resetError = "Oops! Your reset code is incorrect!";
    }
}*/

if (isset($_POST["login"])) {
    $userPass = htmlentities($_POST['password']);
    $userEmail = htmlentities($_POST['email']);
    $verify = password_verify($userPass, $userData->fetchPassword($userEmail));
    // login button was pressed create a session
    // checks to see if password matches
    if ($verify==1)
    {
        $userWebsite = $userData->fetchWebsite($userEmail);
        if($userWebsite == $_SESSION['web-websiteId'])
        {
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $userEmail;
            $_SESSION["userid"] = $userData->fetchId($userEmail);
            $admin = $userData->fetchAdmin($userEmail);
            $userData->fetchUser($_SESSION["userid"]);
            header("Location: index2.php");

            if($admin==1)
            {
                $_SESSION["admin"]=true;
            }
        }

        //$_SESSION["email"] = $userEmail;
        //echo "logged in";
    }

    else
    {
        $view->loggedin = "Oops! Email or password is incorrect!";
        //echo "not logged in";
    }
}

if (isset($_POST["logout"])) {
    // logout button was pressed - end the session
    unset($_SESSION["loggedin"]);
    unset($_SESSION["userid"]);
    unset($_SESSION["admin"]);
}

if($_SESSION['admin'])
{
    $edit = 'this website';
}
else {
    $edit = 'your profile';
}

// actually do something with the page


if (isset($_SESSION["loggedin"])) {
    $view->loggedin = "logged in";
}

require_once('Views/login.phtml');
?>