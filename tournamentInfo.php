<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tournament</title>
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

<div class='container'>
    <?php
    if (isset($_POST['tournamentRegisterSubmit'])) {
        if (isset($_SESSION['id']) AND $_SESSION['id'] == 1) {
            $tournament->AddPlayerTournament($_SESSION['id'], $tournamentID);
            header("Location:index.php?tournamentSignUp=1");
        } else {
            header("Location:login.php?registerUnverified=1");
        }
    }
    if (isset($_POST['tournamentRegisterInterestSubmit'])) {
        if (isset($_SESSION['id']) AND $_SESSION['id'] == 1) {
            $tournament->RegisterInterest($_SESSION['id'], $tournamentID);
            header("Location:index.php?tournamentRegisterInterest=1");
        } else {
            header("Location:login.php?registerUnverified=1");
        }
    }
    ?>
    <div class='container-fluid tournament-info-table'>
        <?php
        if (!isset($_GET['tournamentID'])) {
            if (!isset($_SESSION['tournamentID'])) {
                header('Location:myTournaments.php');

            } else {
                $tournamentID = $_SESSION['tournamentID'];
            }
        } else {
            $tournamentID = $_GET['tournamentID'];
            $_SESSION['tournamentID'] = $_GET['tournamentID'];
        }
        $tournament = new Tournament();
        $startDate = $tournament->GetTournamentArray($tournamentID)['startDate'];
        $endDate = $tournament->GetTournamentArray($tournamentID)['endDate'];

        $startDateNew = strtoupper(date('M d Y', strtotime($startDate)));
        $endDateNew = strtoupper(date('M d Y', strtotime($endDate)));

        echo "<div class='row'>
            <div class='title'>" .
            $tournament->GetTournamentArray($tournamentID)['tournamentName']
            . "</div>
        </div>
        <div class='row'>";

        if ($startDate == $endDate) {
            echo $startDateNew . "</div>";
        } else {
            echo $startDateNew . " - " . $endDateNew . "</div>";
        }
        $sql = "SELECT name FROM location";
        $database = new Database();
        $database->dbConnect();
        $result = $database->conn->query($sql);
        $currentLocation = $tournament->GetLocationName($tournament->GetTournamentArray($tournamentID)['locationID']);

        if (isset($_POST['editTournamentSubmit'])) {
            $locationID = $tournament->GetLocationID($_POST['location']);
            $tournament->EditTournament($_POST['tournamentName'], $_POST['tournamentDescription'], $locationID, $_POST['startDate'], $_POST['endDate'], $_POST['numCourts'], $_POST['contactNumber'], $_POST['minAge'], $_POST['maxAge'], $_POST['experience'], $_POST['price'], $tournamentID);
            header("Location:index.php?editTournamentSuccess=1");
        }

        if (isset($_POST['tournamentCancelSubmit'])) {
            $tournament->TournamentCancel($tournamentID);
        }

        ?>

        <ul class='nav nav-tabs' id='tournamentTabs' role='tablist'>
            <li class='nav-item'>
                <a class='nav-link active' id='information-tab' data-toggle='tab' href='#information' role='tab'
                   aria-controls='home'
                   aria-selected='true'>Information</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' id='schedule-tab' data-toggle='tab' href='#schedule' role='tab'
                   aria-controls='schedule' aria-selected='false'>Schedule</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' id='participants-tab' data-toggle='tab' href='#participants' role='tab'
                   aria-controls='edit' aria-selected='false'>
                    Participants
                </a>
            </li>
            <?php
//            shows the register tab if the tournament is not ongoing or finished
            if (!(($startDate <= date('Y-m-d')))) {
                echo "<li class='nav-item'>
                <a class='nav-link' id='register-tab' data-toggle='tab' href='#register' role='tab' aria-controls='edit'
                   aria-selected='false'>
                    Register
                </a>
            </li>";
            }
//            shows the edit tab if the tournament is owned by the user
            if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] == 1) {
                if ($_SESSION['id'] == $tournament->GetOrganiserID($tournamentID)) {
                    echo "<li class='nav-item'>
                        <a class='nav-link ";
                    if ($startDate <= date('Y-m-d')) {
                        echo "disabled";
                    }

                    echo " ' id='edit-tab' data-toggle='tab' href='#edit' role='tab' aria-controls='edit'
                           aria-selected='false'>Edit</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='delete-tab' data-toggle='tab' href='#delete' role='tab' aria-controls='edit'
                           aria-selected='false'>Delete</a>
                    </li>   ";
                }

            }
            ?>
        </ul>
        <div class='tab-content' id='tournamentTabsContent'>
            <div class='tab-pane fade show active' id='information' role='tabpanel' aria-labelledby='home-tab'>
                <div class='row pb-4'>
                    <div class='col-md-6'>
                        <div class='info-tab-title'>
                            Description
                        </div>
                        <div class='info-tab-text'>
                            <?php echo $tournament->GetTournamentArray($tournamentID)['description'] ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='info-tab-title'>
                            Location
                        </div>
                        <div class='info-tab-text'>
                            <?php echo $tournament->GetLocationName($tournament->GetTournamentArray($tournamentID)['locationID']) ?>
                        </div>
                    </div>
                </div>
                <div class='row pb-4'>
                    <div class='col-md-6 offset-md-6'>
                        <div class='info-tab-title'>
                            Contact number
                        </div>
                        <div class='info-tab-text'>
                            <?php echo $tournament->GetTournamentArray($tournamentID)['contactNum'] ?>
                        </div>
                    </div>
                </div>
                <div class='row pb-4'>
                    <div class='col-md-6'>
                        <div class='info-tab-title'>
                            Age group
                        </div>
                        <div class='info-tab-text'>
                            <?php
                            if ($tournament->HasAgeRange($tournamentID)) {
                                echo $tournament->GetTournamentArray($tournamentID)['minAge'] . " to " . $tournament->GetTournamentArray($tournamentID)['maxAge'];
                            } else {
                                echo $tournament->GetTournamentArray($tournamentID)['minAge'];
                            }
                            ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='info-tab-title'>
                            Price
                        </div>
                        <div class='info-tab-text'>
                            <?php echo $tournament->GetTournamentArray($tournamentID)['price'] ?>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='info-tab-title'>
                            Experience
                        </div>
                        <div class='info-tab-text'>
                            <?php
                            $experience = $tournament->GetTournamentArray($tournamentID)['experience'];
                            $experienceString = "";
                            if ($experience == 1) {
                                $experienceString = "Beginner";
                            } else if ($experience == 2) {
                                $experienceString = "Intermediate";
                            } else {
                                $experienceString = "Advanced";
                            }
                            echo $experienceString
                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class='tab-pane fade ' id='schedule' role='tabpanel' aria-labelledby='schedule-tab'>
                <?php
                if ((isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] = 1) and $tournament->OwnsTournamnt($tournamentID, $_SESSION['id'])) {
                    echo "Generate a schedule";
                } else {
                    echo "schedule";
                }
                ?>
            </div>
            <div class='tab-pane fade' id='participants' role='tabpanel' aria-labelledby='participants-tab'>
                <?php echo $tournament->GetNumPlayers($tournamentID) ?> Players
            </div>
            <div class='tab-pane fade' id='edit' role='tabpanel' aria-labelledby='edit-tab'>
                <form class='needs-validation' action='tournamentInfo.php' method='post' novalidate>
                    <div class='row'>
                        <div class='form-group col-md-6'>
                            <div class='input-label'>
                                Tournament Name
                            </div>
                            <input class='form-control' type='text' name='tournamentName'
                                   value='<?php echo $tournament->GetTournamentArray($tournamentID)['tournamentName'] ?>'
                                   required>
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
                            <textarea class='form-control tournament-description' name='tournamentDescription'
                                      required><?php echo $tournament->GetTournamentArray($tournamentID)['description'] ?></textarea>
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
                                <option disabled selected> Select a location</option>
                                <?php
                                while ($row = $result->fetch_row()) {
                                    if ($row[0] === $currentLocation) {
                                        echo "<option selected> " . $row[0] . " </option>";
                                    } else {
                                        echo "<option>" . $row[0] . " </option>";
                                    }
                                } ?>
                            </select>
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
                            <input class='form-control' type='date' id='startDate' name='startDate'
                                   min='<?php echo date('Y-m-d') ?>' onchange='setMinEndDate(this.value)'
                                   value='<?php echo $tournament->GetTournamentArray($tournamentID)['startDate'] ?>'
                                   required>

                            <div class='invalid-feedback'>
                                Please enter a valid start date
                            </div>
                        </div>
                        <div class='form-group col-md-3'>
                            <div class='input-label'>
                                End date
                            </div>
                            <input class='form-control' type='date' id='endDate' name='endDate'
                                   value='<?php echo $tournament->GetTournamentArray($tournamentID)['endDate'] ?>'
                                   required>
                            <div class='invalid-feedback'>
                                Please enter a valid end date
                            </div>
                        </div>
                    </div>
                    <!--                    NOT DONE-->
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
                                           placeholder='Min age' onchange='setMinMaxAge(this.value)'
                                           value='<?php echo $tournament->GetTournamentArray($tournamentID)['minAge'] ?>'
                                           required>
                                    <div class='invalid-feedback'>
                                        Please enter a valid age
                                    </div>
                                </div>
                                <div class='form-group col-md-6'>
                                    <input class='form-control' name='maxAge' id='maxAge' type='number' max='80'
                                           placeholder='Max age'
                                           value='<?php echo $tournament->GetTournamentArray($tournamentID)['maxAge'] ?>'
                                           required>
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
                                <option <?php if ($tournament->GetTournamentArray($tournamentID)['experience'] == 1) {
                                    echo "selected ";
                                } ?> value='1'>Beginner
                                </option>
                                <option <?php if ($tournament->GetTournamentArray($tournamentID)['experience'] == 2) {
                                    echo "selected ";
                                } ?> value='2'>Intermediate
                                </option>
                                <option <?php if ($tournament->GetTournamentArray($tournamentID)['experience'] == 3) {
                                    echo "selected ";
                                } ?> value='3'>Advanced
                                </option>
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
                            <input class='form-control' name='numCourts' type='number' min='1' max='30'
                                   value='<?php echo $tournament->GetTournamentArray($tournamentID)['numCourts'] ?>'
                                   required>
                            <div class='invalid-feedback'>
                                Please enter a valid number of courts
                            </div>
                        </div>
                        <div class='form-group col-md-2'>
                            <div class='input-label'>
                                Contact number
                            </div>
                            <input class='form-control' name='contactNumber' id='contactNumber' type='number'
                                   min=10000000
                                   max=99999999
                                   value='<?php echo $tournament->GetTournamentArray($tournamentID)['contactNum'] ?>'
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
                                <input class='form-control' name='price' type='number' step='0.1'
                                       value='<?php echo $tournament->GetTournamentArray($tournamentID)['price'] ?>'
                                       required>
                            </div>
                            <div class='invalid-feedback'>
                                Please enter a valid price
                            </div>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-auto my-1'>
                            <input class='form-control btn btn-primary' name='editTournamentSubmit' type='submit'
                                   value='Edit my tournament'>
                        </div>
                    </div>
                </form>
            </div>
            <div class='tab-pane fade ' id='delete' role='tabpanel' aria-labelledby='delete-tab'>
                <div class='font-weight-bold'>Are you sure you want to cancel this tournament? This cannot be undone
                </div>
                <form action='tournamentInfo.php' method='post'>
                    <input class='btn btn-outline-danger' name='tournamentCancelSubmit' type='submit'
                           value='Cancel my tournament'>
                </form>
            </div>
            <div class='tab-pane fade' id='register' role='tabpanel' aria-labelledby='register-tab'>
                <?php
                if (isset($_SESSION['id'])) {
                    if ($tournament->SignedUp($_SESSION['id'], $tournamentID)) {
                        echo "Already signed up";
                    } else {
                        echo "                <div class='row'>
                    <div class='col-md-6'>
                        Are you sure you want to register for this tournament?
                        <form action='tournamentInfo.php' method='post'>
                            <input class='btn btn-outline-primary' type='submit' name='tournamentRegisterSubmit'
                                   value='Register now'>
                        </form>
                    </div>
                    <div class='col-md'>
                        You can register interest for the tournament here
                        <form action='tournamentInfo.php' method='post'>
                            <input class='btn btn-outline-primary' type='submit' name='tournamentRegisterInterestSubmit'
                                   value='Register interest'>
                        </form>
                    </div>
                </div>
    ";
                    }
                } else {
                    echo "<div class='row'>Please log in to register for this tournament</div><div class='row'><a href='login.php'><div class='btn btn-primary'>Log in</div></a></div>";
                }
                ?>
            </div>
        </div>
    </div>
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