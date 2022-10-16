<!DOCTYPE html>
<html>
<head>
    <title>New Tournament</title>
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/main.css">
    <script src="../../scripts/main.js"></script>
</head>
<body>
<div class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../../index.php">Badminton system</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
        <?php
        session_start();
        if (isset($_SESSION['loggedIn'])) {
            echo "<ul class='navbar-nav mr-auto'>
                <li class='nav-item'>
                    <a class='nav-link' href='../../logout.php'>Log out</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='../../newTournament.php'>New Tournament</a>
                </li>
              </ul>";
        } else {
            echo "<ul class='navbar-nav mr-auto'>
                <li class='nav-item'>
                    <a class='nav-link' href='../../login.php'>Login</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='../../register.php'>Register</a>
                </li>
              </ul>";
        }
        ?>
    </div>
</div>

<h1>Create a new tournament</h1>

<?php
if (isset($_SESSION['loggedIn'])) {
    if ($_GET['loggedIn'] = true) {
        echo '<div class="newTournament-wrapper">
        <div class="newTournament-form">
            <form action="../../newTournament.php" method="get">
                Tournament Name <br>
                <input class="form-control" type="text" name="tournamentName" title="Enter the name of your tournament" required>
                <br><br>
                Description <br>
                <textarea class="description-input class=form-control" placeholder="Enter a short description to inform users about your tournament" name="description" title="Enter a short description of the tournament"></textarea>
                <br><br>
                Start date <br>
                <input class="form-control" type="date" name="startDate" min="' . date('Y-m-d') .
            '" title="Enter the date the tournament starts" onchange="setMinEndDate(this.value)" required>
                <br><br>
                End Date <br>
                <input class="form-control" id="endDate" type="date" name="endDate" required>
                <br><br>
                Location <br>
                <input class="location-input form-control" type="text" name="location" placeholder="Enter a location" required>
                <br><br>
                Contact number <br>
                <input class="form-control" type="text" name="contactNum" maxlength="8" minlength="8" title="Enter your contact number" required>
                <br><br>
                Number of courts <br>
                <input class="form-control" type="number" name="numCourts" min="1" max="30" title="Enter the number of courts at the tournament" required>
                <br><br>
                Age group <br>
                <input class="form-control" type="number" name="minAge" min="6" max="90" onchange="setMinMaxAge(this.value)"> to
                <input id="maxAge" type="number" name="maxAge" max="90">
                <br><br>
                Badminton experience <br>
                <select class="form-control" name="badlevel" title="Select the level you would like to see at your competition" required>
                    <option value=0> Any ability</option>
                    <option value=1> Beginner</option>
                    <option value=2> Intermediate</option>
                    <option value=3> Advanced</option>
                </select>
                <br><br>
                <input type="submit" name="submit" value="Submit">
            </form>
            </div>
        </div>';

        if (isset($_GET['submit'])) {
        }
    }
} else {
    $var = $_SESSION['loggedIn'];
    echo $var;
    echo "Please create an account or log in to create a tournament";
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="../../scripts/bootstrap.min.js"></script>

</body>
</html>