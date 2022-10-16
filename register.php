<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Register</title>
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
    <form class='needs-validation' action='register.php' method='get'>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    First Name
                </div>
                <input class='form-control' name='firstName' type='text' required>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Last Name
                </div>
                <input class='form-control' name='lastName' type='text' required>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Username
                </div>
                <input class='form-control' type='text' name='username' placeholder='Username' required>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Password
                </div>
                <input class='form-control' type='text' name='password' required>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Date of birth
                </div>
                <input class='form-control' type='date' name='dateOfBirth'>
            </div>
        </div>
        <div class='row'>
            <div class='form-group col-md-3'>
                <div class='input-label'>
                    Badminton experience
                </div>
                <select class='custom-select'>
                    <option selected disabled>Select the level for this tournament</option>
                    <option value=1>Beginner</option>
                    <option value=2>Intermediate</option>
                    <option value=3>Advanced</option>
                </select>
            </div>
        </div>
        <div class='form-row'>
            <div class='col-md-3 my-1'>
                <input class='btn btn-primary btn-block' type='submit' name='registerSubmit' value='Create my account'>
            </div>
        </div>
    </form>
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