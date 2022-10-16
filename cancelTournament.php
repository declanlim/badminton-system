<?php
include ("classes.php");

if (!isset($_GET['tournamentID'])) {
    header("Location:index.php");
} else {
    $tournamentID = $_GET['tournamentID'];
    $database = new Database();
    $database->dbConnect();

    $sql = "DELETE FROM tournament WHERE tournamentID = " . $tournamentID;
    $sql2 = "DELETE FROM playertournament WHERE tournamentID = " . $tournamentID;
    $database->conn->query($sql);
    $database->conn->query($sql2);

    header("Location:index.php?tournamentDeleted=1");
}