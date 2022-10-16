<?php
session_start();

Class Database
{
    Private $host = 'localhost';
    Private $username = 'declim';
    Private $databaseName = 'badmintonsystem';
    Private $password = 'password';
    Public $conn;

    public function dbConnect()
    {
//        creates a new connection to a database
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->databaseName);
//        checks if the connection is successful
//        outputs an error message if there is an error
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error . '<br><br>');
        } // else {
//            echo 'connection successful <br><br>';
//        }
    }
}

Class User
{
    Public function Register($firstname, $lastname, $username, $password, $dob, $ability)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "INSERT INTO players(firstName, lastName, username, password, dateOfBirth, ability)
                    VALUES('$firstname', '$lastname', '$username', '$password', '$dob','$ability')";

        if ($this->UsernameExists($username)) {
            echo '<br> The username is already taken, please choose a different username';
        } else {
            if ($database->conn->query($sql)) {
                echo 'Account created successfully';
            } else {
                $error = $database->conn->error;
                echo "error adding account details to the database <br><br> $error";
            }
        }

        $database->conn->close();
    }

    Public function Login($username, $password)
    {
        $database = new Database();
        $database->dbConnect();

        //                   stores session variables
        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $this->GetUserID($username);
    }

    Public function UsernameExists($username)
    {
//        establishes a connection with the database
        $database = new Database();
        $database->dbConnect();

//        runs an SQL query to get the nymber of rows where the username is the same as the parameter supplied
//        the count returned will wither be 0 or 1 and can be interpreted as a boolean
        $sql = "SELECT COUNT(username) AS valid FROM players WHERE username = '$username'";
        $valid = $database->conn->query($sql)->fetch_array()['valid'];

//         closes the connection to the database
        $database->conn->close();

//        returns the number of rows
        return $valid;
    }

    Public function CheckPassword($username, $password)
    {
        $database = New Database();
        $database->dbConnect();

        $sql = "SELECT COUNT(*) AS result FROM players WHERE username = '$username' AND password = '$password'";
        $result = $database->conn->query($sql)->fetch_array()['result'];

        return $result;

    }

    Public function Logout()
    {
        //Starts the session
        if (!isset($_SESSION['loggedIn'])) {
            return false;
        } else {
            //Resets the session array and destroys the session
            $_SESSION = [];
            session_destroy();
            return true;
        }
    }

    Public function GetUserID($username)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT playerID AS 'id' FROM players WHERE username = '$username'";

        $result = $database->conn->query($sql)->fetch_array()['id'];
        return $result;
    }
}

Class Tournament
{
    Public function NewTournament($tournamentName, $description, $locationid, $startDate, $endDate, $numCourts, $contactNum, $minAge, $maxAge, $experience, $price)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "INSERT into tournament(tournamentName, organiserID,description,locationID,startDate,endDate,numCourts,contactNum,minAge,maxAge,experience,price) VALUES('$tournamentName', '" . $_SESSION['id'] . "','$description','$locationid','$startDate','$endDate','$numCourts','$contactNum','$minAge','$maxAge','$experience','$price')";
        $database->conn->query($sql);

    }

    private function AddTournamentDayTime($tournamentID, $day, $startTime, $endTime)
    {
        $database = new Database();
        $database->dbConnect();
        $sql = "INSERT INTO tournamentdaytime(tournamentID, day, startTime, endTime) VALUES('$tournamentID', '$day', '$startTime', '$endTime')";
        $database->conn->query($sql);
    }

    Public function EditTournament($tournamentName, $description, $locationid, $startDate, $endDate, $numCourts, $contactNum, $minAge, $maxAge, $experience, $price, $tournamentid)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "UPDATE tournament SET tournamentName = '$tournamentName', description = '$description', locationID = '$locationid', startDate = '$startDate', endDate = '$endDate', numCourts = '$numCourts', contactNum = '$contactNum', minAge = '$minAge', maxAge = '$maxAge', experience = '$experience', price = '$price' WHERE tournamentID = '$tournamentid'";
//        $sql = "UPDATE tournament SET tournamentName='$tournamentName' WHERE tournamentID = '$tournamentid'";
        $database->conn->query($sql);
    }

//  FUNCTION TO CHECK IF A LOCATION EXISTS
//    Public function LocationExists($name)
//    {
//        $database = New Database();
//        $database->dbConnect();
//
//        $sql = "SELECT COUNT(*) AS result FROM location WHERE name = '$name'";
//        $count = $database->conn->query($sql)->fetch_array()['result'];
//
//        return $count;
//    }

    Public function GetLocationID($location)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT locationID AS 'id' FROM location WHERE name='$location'";
        $result = $database->conn->query($sql)->fetch_array()['id'];

        return $result;
    }

    Public function GetLocationName($id)
    {
        $database = new Database();
        $database->dbConnect();
        $sql = "SELECT name AS 'name' FROM location WHERE locationID = '$id'";

        $result = $database->conn->query($sql)->fetch_array()['name'];
        return $result;

    }

    Public function GetTournamentID($name, $description)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT tournamentID  as 'id' FROM tournament WHERE tournamentName='$name' AND description='$description'";
        $result = $database->conn->query($sql)->fetch_array()['id'];

        return $result;
    }


    Public function GetUserTournaments()
    {
        $organiserID = $_SESSION['id'];
        $database = new Database();
        $database->dbConnect();
        $sql = "SELECT tournamentID  FROM tournament WHERE organiserID = '$organiserID' ORDER BY startDate ASC";
        $result = $database->conn->query($sql);
        return $result;
    }

    Public function GetNumTournamentsOrganised()
    {
        $organiserID = $_SESSION['id'];
        $database = new Database();
        $database->dbConnect();
        $sql = "SELECT COUNT(tournamentID) AS 'count' FROM tournament WHERE organiserID = '$organiserID'";
        $result = $database->conn->query($sql)->fetch_array()['count'];

        return $result;

    }

    Public function GetTournamentArray($tournamentID)
    {
        $database = new Database();
        $database->dbConnect();
        $sql = "SELECT * FROM tournament WHERE tournamentID = '$tournamentID'";
        $result = $database->conn->query($sql)->fetch_array();
        return $result;
    }


    Public function GetNumPlayers($id)
    {
        $database = New Database();
        $database->dbConnect();

        $sql = "SELECT COUNT(playerID) AS 'count' FROM playertournament WHERE tournamentID = '$id'";
        $result = $database->conn->query($sql)->fetch_array()['count'];
        return $result;
    }

//    Public function GetNumOpenTournaments()
//    {
//        $database = new Database();
//        $database->dbConnect();
//
//        $sql = "SELECT COUNT(tournamentID)  as 'id' FROM tournament WHERE startDate < '" . date('Y-m-d') . "'";
//        $result = $database->conn->query($sql)->fetch_array()['id'];
//        return $result;
//    }

    Public function GetOpenTournments()
    {
        $database = new Database();
        $database->dbConnect();
        $organiserBool = isset($_SESSION['id']);

        if ($organiserBool) {
            $sql = "SELECT tournamentID FROM tournament WHERE startDate > '" . date('Y-m-d') . "' AND organiserID != " . $_SESSION['id'];
        } else {
            $sql = "SELECT tournamentID FROM tournament WHERE startDate > '" . date('Y-m-d') . "'";
        }
//        echo $this->GetNumOpenTournaments() ;
        $result = $database->conn->query($sql);

        return $result;
    }

    Private function GetNumOpenTournaments()
    {
        $database = new Database();
        $database->dbConnect();

        $organiserBool = isset($_SESSION['id']);
        if ($organiserBool) {
            $sql = "SELECT COUNT(tournamentID) FROM tournament WHERE startDate > '" . date('Y-m-d') . "' AND organiserID != " . $_SESSION['id'];
        } else {
            $sql = "SELECT COUNT(tournamentID) FROM tournament WHERE startDate > '" . date('Y-m-d') . "'";
        }
        $result = $database->conn->query($sql)->fetch_array()[0];
//        echo $result;
        return $result;
    }

    Public function GetPastTournments()
    {
        $database = new Database();
        $database->dbConnect();

        $organiserBool = isset($_SESSION['id']);

        if ($organiserBool) {
            $sql = "SELECT tournamentID FROM tournament WHERE  endDate < '" . date('Y-m-d') . "' AND organiserID != " . $_SESSION['id'];
        } else {
            $sql = "SELECT tournamentID FROM tournament WHERE  endDate < '" . date('Y-m-d') . "'";
        }

        $result = $database->conn->query($sql);

        return $result;
    }

    Public function GetOngoingTournments()
    {
        $database = new Database();
        $database->dbConnect();

        $organiserBool = isset($_SESSION['id']);

        if ($organiserBool) {
            $sql = "SELECT tournamentID FROM tournament WHERE  endDate < '" . date('Y-m-d') . "' AND organiserID != " . $_SESSION['id'];
        } else {
            $sql = "SELECT tournamentID FROM tournament WHERE  endDate < '" . date('Y-m-d') . "'";
        }

        $sql = "SELECT tournamentID FROM tournament WHERE startDate <= '" . date('Y-m-d') . "' AND endDate >= '" . date('Y-m-d') . "'";
        $result = $database->conn->query($sql);

        return $result;
    }

    Public function GetTournamentOrganiser($tournamentID)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT players.username FROM players, tournament WHERE tournament.tournamentID = " . $tournamentID . " AND players.PlayerID = tournament.organiserID";
        $result = $database->conn->query($sql)->fetch_array()[0];
        return $result;
    }

    Public function GetOrganiserID($tournamentID)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT organiserID AS 'id' FROM tournament WHERE tournamentID = " . $tournamentID;
        $result = $database->conn->query($sql)->fetch_array()['id'];
        return $result;
    }

    Public function IsPlayerRegistered($playerid, $tournamentid)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT COUNT(playerID) FROM playertournament WHERE tournamentID = " . $tournamentid . " AND playerID = " . $playerid;
        $result = $database->conn->query($sql)->fetch_array()[0];
        return $result;
    }

    Public function TournamentCancel($tournamentID)
    {
        if ($tournamentID == null) {
            header("Location:index.php");
        } else {
            $database = new Database();
            $database->dbConnect();

            $sql = "DELETE FROM tournament WHERE tournamentID = " . $tournamentID;
            $sql2 = "DELETE FROM playertournament WHERE tournamentID = " . $tournamentID;
            $database->conn->query($sql);
            $database->conn->query($sql2);

            header("Location:index.php?tournamentDeleted=1");
        }
    }

    Public function AddPlayerTournament($playerID, $tournamentID)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT COUNT($playerID) FROM playertournament WHERE playerID = '$playerID' AND tournamentID = '$tournamentID' AND ";

        $sql = "INSERT INTO playertournament(playerID, tournamentID) VALUES('$playerID', '$tournamentID')";

        $database->conn->query($sql);
    }

    Public function RegisterInterest($playerID, $tournamentID)
    {
        $database = new Database();
        $database->dbConnect();

        $sql = "INSERT INTO playertournament(playerID, tournamentID,interest) VALUES('$playerID', '$tournamentID', 1)";

        $database->conn->query($sql);
    }

    Public function SignedUp($playerID, $tournamentID)
    {
        $sql = "SELECT COUNT(playerID) FROM playertournament WHERE playerID = '$playerID' AND tournamentID = '$tournamentID'";
        $database = new Database();
        $database->dbConnect();

        $result = $database->conn->query($sql)->fetch_array()[0];
        return $result;
    }

    Public function HasAgeRange($tournamentID)
    {
        $database = new Database();
        $database->dbConnect();

        $minAge = $this->GetTournamentArray($tournamentID)['minAge'];
        $maxAge = $this->GetTournamentArray($tournamentID)['maxAge'];

        if ($minAge == $maxAge) {
            return false;
        } else {
            return true;
        }
    }

    Public function OwnsTournamnt($tournamentID, $playerID)
    {
        if ($this->GetTournamentArray($tournamentID)['organiserID'] == $playerID) {
            return true;
        } else {
            return false;
        }
    }
}

Class Schedule
{
    Private $numPlayers;
    Private $numCourts;


    public function __construct($numCourts, $numPlayers)
    {
        $this->$numCourts = $numCourts;
        $this->$numPlayers = $numPlayers;
    }
}


