<select class='custom-select'>
<?php
/**
 * Created by PhpStorm.
 * User: Declan Lim
 * Date: 22/11/2018
 * Time: 13:52
 */
include('classes.php');
$sql = "SELECT name FROM location";

$database = new Database();
$database->dbConnect();

$result = $database->conn->query($sql);

while ($row = $result->fetch_row()) {
    echo '<option>' . $row[0] . '</option>';
}
?>
</select>


