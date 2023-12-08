<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            background-color: #D5F5E3;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .login-tab {
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .tab {
            display: flex;
            justify-content: space-around;
            background-color: #4CAF50;
            border-radius: 5px;
        }

        .tab button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .tab button:hover {
            background-color: #45a049;
        }

        .tabcontent {
            display: none;
        }

        .active {
            display: block;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<?php
include('logo.php');
?>

    <?php
    require ('login.php');
    ?>

</body>
</html>

