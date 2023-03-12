<?php
    include("config.php");
    session_start();

    // get the variables necessary to make money transfer
    $transferFrom = $_POST['from'];
    $transferTo = $_POST['to'];
    $moneyAmount = $_POST['moneyAmount'];

    $cid = $_SESSION['cid'];

    $query = "SELECT balance FROM account WHERE aid = '$transferFrom'";

    $result = $con->query($query);

    if ( !$result) {
        die( "Error in retrieving data from the database: " . $con->error);
    }

    $balance = mysqli_fetch_array($result)['balance'];

    if ( $balance < $moneyAmount) {
        echo "<script>alert('Selected account balance is insufficient to make the transfer. (Source account balance: $balance TL, desired transfer amount: $moneyAmount TL)');
                document.location = 'transfer.php';</script>";
    }
    else {
        // Update the balance of the source account
        $updateSourceBalanceQuery = "UPDATE account SET balance = $balance - $moneyAmount WHERE aid = '$transferFrom'";
        $result = $con->query($updateSourceBalanceQuery);
        if ( !$result) {
            die( "Error updating the database: " . $con->error);
        }

        // Receive the balance of the destination account
        $query = "SELECT balance FROM account WHERE aid = '$transferTo'";
        $result = $con->query($query);

        if ( !$result) {
            die( "Error in retrieving data from the database: " . $con->error);
        }

        $balanceDest = mysqli_fetch_array($result)['balance'];
        // Update the balance of the destination account
        $updateDestBalanceQuery = "UPDATE account SET balance = $balanceDest + $moneyAmount WHERE aid = '$transferTo'";
        $result = $con->query($updateDestBalanceQuery);

        if ( !$result) {
            die( "Error updating the database: " . $con->error);
        }

        echo "<script>alert('Money transfer of $moneyAmount TL from account ID $transferFrom to $transferTo is successful.');
                document.location = 'transfer.php';</script>";
    }


?>