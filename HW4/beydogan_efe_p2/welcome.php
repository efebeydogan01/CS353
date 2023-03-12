<?php
include("config.php");
session_start();
if (!isset($_SESSION['name']))
{
	header("location: index.php");
}
$cid = $_SESSION['cid'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Accounts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        p { margin-bottom: 10px; }
        * {
           font-size: 20px;
           text-align: center;
        }
        h1 {
            font-size: 40px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #a5a5a5;
            color: white;
        }
        tr:hover {
            background-color: #fdfd95;
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <h5 class="navbar-text">Welcome, <?php echo strtoupper($name); ?></h5>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
				
            </ul>
        </div>

    </nav>
    <div class="panel container-fluid">
        <h3 class="page-header" style="font-weight: bold;">Bank Accounts</h3>
		<?php
        // Receive bank account information from the database
        $query = "SELECT aid, branch, balance, openDate FROM account natural join owns WHERE cid = '$cid'";
        $result = $con->query($query);

        if (!$result) {
            die( "Error in retrieving data from the database: " . $con->error);
        }

        echo "<table>
                <tr> <th>Account ID</th> <th>Branch</th> 
                <th>Balance (TL)</th> <th>Date Opened</th> <th>Close Account</th> </tr>";

        while($row = mysqli_fetch_array($result)) 
		{
            // get the necessary information
            $aid = $row["aid"];
            $branch = $row['branch'];
            $balance = $row["balance"];
            $openDate = $row["openDate"];
            echo "<tr> <td> $aid </td>
                    <td> $branch </td>
                    <td> $balance </td>
                    <td> $openDate </td>
                    <td>  <a href=\"close.php?aid=$aid\" class=\"btn btn-danger\">Close</a> </td> </tr>";
        }

        echo "</table>";

        // get the number of available accounts the user has to determine if they can make money transfer
        $query = "SELECT count(*) as no_of_accounts FROM owns WHERE cid = '$cid'";
        $result = $con->query($query);

        if (!$result) {
            die( "Error in retrieving data from the database: " . $con->error);
        }

        $no_of_accounts = (int) mysqli_fetch_array($result)['no_of_accounts'];

        if ( $no_of_accounts === 0) {
            echo "You have no accounts in our database.";
            echo "<br> <a class=\"btn btn-primary disabled\">Make Money Transfer</a>";
        }
        else {
            echo "<br> <a href='transfer.php' class=\"btn btn-info\">Make Money Transfer</a>";
        }
        ?>
    </div>
</div>
</body>
</html>