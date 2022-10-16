<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

<div class="register-wrapper">
    <div class="register-error">
    </div>
    <div class="register-form">
        <form action="register.php" method="get">
            First name
            <br>
            <input type="text" name="firstname" title="Please enter your first name" required>
            <br><br>
            Last name
            <br>
            <input type="text" name="lastname" title="Please enter your last name" required>
            <br><br>
            Username
            <br>
            <input type="text" name="username" title="Choose a username to be shown on the system" required>
            <br><br>
            Password
            <br>
            <input type="password" name="password" title="Choose a strong password" required>
            <br><br>
            Date of birth
            <br>
            <input type="date" name="dob" title="Please enter your date of birth" required>
            <br><br>
            Badminton experience
            <br>
            <select name="badlevel" title="Select your rough level of badminton" required>
                <option selected>Select your rough level of badminton</option>
                <option value=1> Beginner</option>
                <option value=2> Intermediate</option>
                <option value=3> Advanced</option>
            </select>
            <br><br><br><br>
            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    <?php
    if (isset($_GET['submit'])) {
        $user = new User();
        $user->Register($_GET['firstname'], $_GET['lastname'], $_GET['username'], $_GET['password'], $_GET['dob'], $_GET['badlevel']);
        echo "<br> <br>";
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