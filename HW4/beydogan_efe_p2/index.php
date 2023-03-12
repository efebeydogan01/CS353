<?php
include("config.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        #centerwrapper {
            text-align: center;
            margin-bottom: 10px;
        }

        #centerdiv {
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <h4 class="navbar-text">Bank Site</h4>
                </div>
            </div>
        </nav>
        <div id="centerwrapper">
            <div id="centerdiv">
                <br><br>
                <h2>Login to the Bank Site</h2>
                <p>Please enter your name and password to login.</p>
                <form id="loginForm" name="loginForm" action="login.php" method="post">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="customername" class="form-control" id="customername" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input onclick="checkInput()" name="submitButton" value="Login" class="btn btn-primary" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function checkInput() {
            var name = document.getElementById("customername").value;
            var password = document.getElementById("password").value;
            if (name === "" || password === "") {
                alert("Fill both fields to login!");
            } else {
                var form = document.getElementById("loginForm").submit();
            }
        }
    </script>
</body>

</html>