<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>New Tournament</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="scripts/main.js"></script>
</head>
<body>
<div class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Badminton system</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class='navbar-nav mr-auto'>
            <li class='nav-item'>
                <a class='nav-link' href='newTournament.php'>New Tournament</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='myTournaments.php'>My Tournaments</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='viewTournaments.php'>Register for a Tournament</a>
            </li>
        </ul>

        <ul class='navbar-nav ml-auto'>
            <form class='form-inline ' action='search.php' method='get'>
                <input class=' form-control' type='text' name='search' placeholder='Search...'>
            </form>
            <?php
            require('classes.php');
            if (isset($_SESSION['loggedIn'])) {
                echo "
                <li class='nav-item'>
                    <a class='nav-link' href='logout.php'>Log out</a>
                </li>";
            } else {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='login.php'>Login</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='register.php'>Register</a>
                </li>";
            }
            ?>
        </ul>
    </div>
</div>

<div class='container-fluid'>
    <?php
    if (isset($_SESSION['loggedIn'])) {
        if (isset($_GET['submit'])) {
            $tournament = New Tournament();
            $locationID = $tournament->GetLocationID($_GET['location']);

            $tournament->NewTournament($_GET['tournamentName'], $_GET['tournamentDescription'], $locationID, $_GET['startDate'], $_GET['endDate'], $_GET['numCourts'], $_GET['contactNumber'], $_GET['minAge'], $_GET['maxAge'], $_GET['experience'], $_GET['price']);
            header("Location:index.php?tournamentSuccess=1");

        } else {
            $sql = "SELECT name FROM location";
            $database = new Database();
            $database->dbConnect();
            $result = $database->conn->query($sql);

            echo "<h1>Create a new tournament</h1>
    <form class='needs-validation' action='newTournament.php' method='get' novalidate>
        <div class='row'>
            <div class='form-group col-md-6'>
                <div class='input-label'>
                    Tournament Name
                </div>
                <input class='form-control' type='text' name='tournamentName' required>
                <div class='invalid-feedback'>
                    Please enter a valid tournament name
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-6'>
                <div class='input-label'>
                    Tournament Description
                </div>
                <textarea class='form-control tournament-description' name='tournamentDescription' required></textarea>
                <div class='invalid-feedback'>
                    Please write a short description for your tournament
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-6'>
                <div class='input-label'>
                    Location
                </div>
                <select name='location' class='custom-select' required>
                <option disabled selected> Select a location </option>";
            while ($row = $result->fetch_row()) {
                echo '<option>' . $row[0] . '</option>';
            }
            echo "</select>
                <div class='invalid-feedback'>
                    Please select a valid location
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Start date
                </div>
                <input class='form-control' type='date' id='startDate' name='startDate' min='" . date('Y-m-d') . "' onchange='setMinEndDate(this.value)' required>
                       
                <div class='invalid-feedback'>
                    Please enter a valid start date
                </div>
            </div>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    End date
                </div>
                <input class='form-control' type='date' id='endDate' name='endDate' required>
                <div class='invalid-feedback'>
                    Please enter a valid end date
                </div>
            </div>

        </div>
        <div class='row'>
            <div id='day-form'>
                
            </div>
        </div>
        <div class='row'>
            <div class='col-md-3'>
                <div class='input-label'>
                    Age group
                </div>
                <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <input class='form-control' name='minAge' type='number' min='6' max='80'
                               placeholder='Minimum age' onchange='setMinMaxAge(this.value)' required>
                        <div class='invalid-feedback'>
                            Please enter a valid age
                        </div>
                    </div>
                    <div class='form-group col-md-6'>
                        <input class='form-control' name='maxAge' id='maxAge' type='number' max='80'
                               placeholder='Maximum age' required>
                        <div class='invalid-feedback'>
                            Please enter a valid age
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-3 '>
                <div class='input-label'>
                    Badminton ability
                </div>
                <select name='experience' class='custom-select' required>
                    <option selected disabled>Select the level for this tournament</option>
                    <option value='1'>Beginner</option>
                    <option value='2'>Intermediate</option>
                    <option value='3'>Advanced</option>
                </select>
                <div class='invalid-feedback'>
                    Please select an ability for the tournament
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-2'>
                <div class='input-label'>
                    Number of courts
                </div>
                <input class='form-control' name='numCourts' type='number' min='1' max='30' required>
                <div class='invalid-feedback'>
                    Please enter a valid number of courts
                </div>
            </div>
            <div class='form-group col-md-2'>
                <div class='input-label'>
                    Contact number
                </div>
                <input class='form-control' name='contactNumber' id='contactNumber' type='number' min=10000000
                       max=99999999
                       required '>
                <div class='invalid-feedback'>
                    Please enter a valid phone number
                </div>
            </div>
            <div class='form-group col-md-2'>
                <div class='input-label'>
                    Price
                </div>
                <div class='input-group'>
                    <div class='input-group-prepend'>
                        <span class='input-group-text'>$</span>
                    </div>
                    <input class='form-control' name='price' type='number'>
                </div>
                <div class='invalid-feedback'>
                    Please enter a valid price
                </div>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-auto my-1'>
                <input class='form-control btn btn-primary' name='submit' type='submit' value='Create my tournament'>
            </div>
        </div>
    </form>";
        }
    } else {
        header("Location:login.php?newTournament=1");
    }

    ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>

</body>
</html>