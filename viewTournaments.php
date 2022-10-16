<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Badminton system</title>
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
    <div class='row title'>
        Tournaments
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="open-tab" data-toggle="tab" href="#open" role="tab" aria-controls="open"
               aria-selected="true">Open</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab" aria-controls="past"
               aria-selected="false">Past</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="ongoing-tab" data-toggle="tab" href="#ongoing" role="tab" aria-controls="ongoing"
               aria-selected="false">Ongoing</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
            <?php
            $tournament = new Tournament();
            $tournamentsResult = $tournament->GetOpenTournments();
            if ($tournamentsResult->fetch_array() != null) {
                echo "<div class='container-fluid tournament-table'>
                        <div class='row tournament-table-header'>
                            <div class='col-md-2'>
                            Date
                        </div>
                        <div class='col-md-3'>
                            Name
                        </div>
                        <div class='col-md-4'>
                            Location
                        </div>
                        <div class='col-md-3'>
                            Organiser
                        </div>
                        </div>
                    </div>";
                foreach ($tournamentsResult as $row) {
                    $id = $row['tournamentID'];
                    $locationID = $tournament->GetTournamentArray($id)['locationID'];
                    $location = $tournament->GetLocationName($locationID);
                    $organiser = $tournament->GetTournamentOrganiser($id);
                    echo "<div class='row tournamentTableRow  '>
                        <div class='col-md-2'>" . $tournament->GetTournamentArray($id)['startDate'] . "
                        </div>
                        <div class='col-md-3'> <a href='tournamentInfo.php?tournamentID=" . $id . "'>" . $tournament->GetTournamentArray($id)['tournamentName'] . "</a></div>
                        <div class='col-md-4'>" . $location . "</div>
                        <div class='col-md-3'>" . $organiser . "</div>
                    </div>";
                }
            } else {
                echo "No open tournaments found";
            }
            ?>
        </div>
        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            <?php
            $tournament = new Tournament();
            $tournamentsResult = $tournament->GetPastTournments();
//            echo $tournamentsResult->fetch_array();
            if ($tournamentsResult->fetch_array() != null) {
                echo "<div class='container-fluid tournament-table'>
                        <div class='row tournament-table-header'>
                            <div class='col-md-2'>
                            Date
                        </div>
                        <div class='col-md-3'>
                            Name
                        </div>
                        <div class='col-md-4'>
                            Location
                        </div>
                        <div class='col-md-3'>
                            Organiser
                        </div>
                        </div>
                    </div>";
                foreach ($tournamentsResult as $row) {
                    $id = $row['tournamentID'];
                    $locationID = $tournament->GetTournamentArray($id)['locationID'];
                    $location = $tournament->GetLocationName($locationID);
                    $organiser = $tournament->GetTournamentOrganiser($id);
                    echo "<div class='row tournamentTableRow  '>
                        <div class='col-md-2'>" . $tournament->GetTournamentArray($id)['startDate'] . "
                        </div>
                        <div class='col-md-3'> <a href='tournamentInfo.php?tournamentID=" . $id . "'>" . $tournament->GetTournamentArray($id)['tournamentName'] . "</a></div>
                        <div class='col-md-4'>" . $location . "</div>
                        <div class='col-md-3'>" . $organiser . "</div>
                    </div>";
                }
            } else {
                echo "No past tournaments found";
            }
            ?>
        </div>
        <div class="tab-pane fade" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
            <?php
            $tournament = new Tournament();
            $tournamentsResult = $tournament->GetOngoingTournments();
            if ($tournamentsResult->fetch_array() != null) {
                echo "<div class='container-fluid tournament-table'>
                        <div class='row tournament-table-header'>
                            <div class='col-md-2'>
                            Date
                        </div>
                        <div class='col-md-3'>
                            Name
                        </div>
                        <div class='col-md-4'>
                            Location
                        </div>
                        <div class='col-md-3'>
                            Organiser
                        </div>
                        </div>
                    </div>";
                foreach ($tournamentsResult as $row) {
                    $id = $row['tournamentID'];
                    $locationID = $tournament->GetTournamentArray($id)['locationID'];
                    $location = $tournament->GetLocationName($locationID);
                    $organiser = $tournament->GetTournamentOrganiser($id);
                    echo "<div class='row tournamentTableRow  '>
                        <div class='col-md-2'>" . $tournament->GetTournamentArray($id)['startDate'] . "
                        </div>
                        <div class='col-md-3'> <a href='tournamentInfo.php?tournamentID=" . $id . "'>" . $tournament->GetTournamentArray($id)['tournamentName'] . "</a></div>
                        <div class='col-md-4'>" . $location . "</div>
                        <div class='col-md-3'>" . $organiser . "</div>
                    </div>";
                }
            } else {
                echo "No past tournaments found";
            }
            ?>
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