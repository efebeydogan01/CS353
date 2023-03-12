<?php
include("config.php");
session_start();
if (!isset($_SESSION['name']))
{
	header("location: index.php");
}

$cid = $_SESSION['cid'];
$name = strtoupper( $_SESSION['name']);

$query = "SELECT count(*) as account_count FROM owns WHERE cid = '$cid'";
$result = $con->query( $query);

if ( !$result) {
    die( "Error in retrieving data from the database: " . $con->error);
}

$account_count = (int) mysqli_fetch_array($result)['account_count'];

if ( $account_count === 0) {
    header("location: welcome.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Money Transfer Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
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
        caption {
            text-align: left;
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
            background-color: #fdfd96;
        }
        select {
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href='welcome.php' class="btn btn-primary">Back to Welcome Page</a>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
				
            </ul>
        </div>

    </nav>
    <div class="panel container-fluid">
        <h3 class="page-header" style="font-weight: bold;">Money Transfer</h3>
		<?php
            // get customer accounts
            $query = "SELECT aid, branch, balance, openDate FROM account natural join owns WHERE cid = '$cid'";
            $result = $con->query( $query);

            if ( !$result) {
                die( "Error in retrieving data from the database: " . $con->error);
            }
            $transferFrom = "<br> Select the account to transfer money from: <br> <select name='from' required>
                                <option value=''>None</option>";

            echo " <caption> <strong> Accounts belonging to $name: </strong> </caption> <table>
                    <tr> <th>Account ID</th> <th>Branch</th> <th>Balance (TL)</th>
                    <th> Date Opened </th> </tr>";
            
            while ( $row = mysqli_fetch_array($result)) {
                $aid = $row['aid'];
                $branch = $row['branch'];
                $balance = $row["balance"];
                $openDate = $row["openDate"];

                echo "<tr> <td> $aid </td>
                        <td> $branch </td>
                        <td> $balance </td>
                        <td> $openDate </td> </tr>";
                
                $transferFrom .= "<option value='$aid'>$aid</option>";
            }
            echo "</table>";
            $transferFrom .= '</select><br>';

            // get all accounts available in the system
            $query = "SELECT distinct aid, branch, balance, openDate FROM account natural join owns";
            $result = $con->query($query);

            if ( !$result) {
                die( "Error in retrieving data from the database: " . $con->error);
            }

            $transferTo = "Select the account to make money transfer to: <br> <select name='to' required>
                            <option value=''>None</option>";

            echo "<br> <caption> <strong> All available accounts in the bank: </strong> </caption><table> 
                    <tr> <th>Account ID</th> <th>Branch</th> <th>Balance (TL)</th> <th> Date Opened </th> </tr>";

            while ( $row = mysqli_fetch_array($result)) {
                $aid = $row['aid'];
                $branch = $row['branch'];
                $balance = $row['balance'];
                $openDate = $row["openDate"];

                echo "<tr> <td> $aid </td>
                        <td> $branch </td>
                        <td> $balance </td>
                        <td> $openDate </td> </tr>";
                
                $transferTo .= "<option value='$aid'>$aid</option>";
            }
            echo "</table>";

            $transferTo .= '</select><br> Transfer amount: <br>';

            echo "<form method='post' action='makeTransfer.php'" . $transferFrom . $transferTo . 
                        "<input type='text' id='moneyAmount' name='moneyAmount' pattern='[0-9]*' placeholder='Please provide a valid number' required>" . 
                        "<br> <button type='submit' class='btn btn-success'>Transfer Money</button>" . "</form>"; 
        ?>
    </div>
</div>
<script>
    var input = document.querySelectorAll('input');
    for(i=0; i<input.length; i++){
        input[i].setAttribute('size',input[i].getAttribute('placeholder').length);
    }
</script>
</body>
</html>