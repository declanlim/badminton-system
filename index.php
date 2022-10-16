<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Badminton system</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
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
    if (isset($_GET['logOut']) && $_GET['logOut'] == 1) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        You have successfully logged out
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    if (isset($_GET['tournamentSuccess']) && $_GET['tournamentSuccess'] == 1) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Tournament created!
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    if (isset($_GET['editTournamentSuccess']) && $_GET['editTournamentSuccess'] == 1) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Tournament Edited!
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    if (isset($_GET['tournamentDeleted']) && $_GET['tournamentDeleted'] == 1) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Tournament was cancelled
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
     if (isset($_GET['tournamentSignUp']) && $_GET['tournamentSignUp'] == 1) {
         echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
             Successfully signed up for tournament
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
     }


    if (isset($_SESSION['loggedIn'])) {
        $database = new Database();
        $database->dbConnect();

        $sql = "SELECT firstName as 'name' FROM players WHERE playerID = '" . $_SESSION['id'] . "'";
        $result = $database->conn->query($sql)->fetch_array()['name'];

        echo "Welcome " . $result . "<br><br>";
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
