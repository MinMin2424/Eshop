<?php

session_start();

    if($_SESSION["user"]["username"] !== "MinMin24") {
        header("Location: ../index.php");
        exit(0);
    }

include("./data_functions.php");

$allUsers = getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seznam Users</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/seznam.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Space%20Grotesk">
</head>
<body>

    <section>
        <h1>Seznam všech users</h1>
        <a href="../user-page.php">Go back!</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Country</th>
                <th>City</th>
                <th>Region</th>
                <th>Postal Code</th>
                <th>Password</th>
                <th></th>
            </tr>
            <?php
            foreach ($allUsers as $user) {
                echo ("\n<tr><td>".htmlspecialchars($user['id'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['username'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['email'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['phone-number'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['birth-date'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['gender'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['address'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['country'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['city'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['region'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['postal-code'])."</td>\n");
                echo ("<td>".htmlspecialchars($user['hashed-password'])."</td>\n");

                echo ("<td><a href='./edit-data.php?id={$user['id']}'>Edit</a></td></tr>\n");
            }
            ?>
        </table>

</section>

</body>
</html>


