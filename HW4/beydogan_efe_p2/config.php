<?php
define("DB_NAME", "efe_beydogan");
define("DB_USERNAME", "efe.beydogan");
define("DB_PASSWORD", "dCMFpIeU");
define("HOST", "dijkstra.ug.bcc.bilkent.edu.tr");

$con = new mysqli(HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($con->connect_error) {
    die( "MySQL database connection error: (" . $con->connect_error . ")");
}
?>
