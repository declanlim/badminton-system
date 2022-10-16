<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>My Tournaments</title>
</head>
<body>
<?php
require('classes.php');
if (!isset($_SESSION['id'])) {
    header("Location:login.php?viewTournament=1");
}
?>

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

<!--NOT RESPONSIVE-->
<div class='container-fluid'>
    <?php
    $tournament = new Tournament();
    if ($tournament->GetNumTournamentsOrganised() > 0) {
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
                            Number of players
                        </div>
                    </div>";
        foreach ($tournament->GetUserTournaments() as $row) {
            $id = $row['tournamentID'];
            $locationID = $tournament->GetTournamentArray($id)['locationID'];
            $location = $tournament->GetLocationName($locationID);

            echo "<div class='row tournamentTableRow  '>
                        <div class='col-md-2'>" . $tournament->GetTournamentArray($id)['startDate'] . "
                        </div>
                        <div class='col-md-3'> <a href='tournamentInfo.php?tournamentID=" . $id . "'>" . $tournament->GetTournamentArray($id)['tournamentName'] . "</a></div>
                        <div class='col-md-4'>" . $location . "</div>
                        <div class='col-md-3'>" . $tournament->GetNumPlayers($id) . "</div>
                    </div>";
        }
    } else {
//      NEED TO ALIGN CENTER
        echo "<div class='row'>
                <div class='col-md text-center display-4'>
                    No tournaments found
                </div>
            </div>
            <div class='row'>
                <a  href='newTournament.php'><button class='btn btn-primary'>Create my first tournament</button></a>                
            </div>";
    }
    ?>
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