<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$message = "Welcome " . $_SESSION['username'];

$theme = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>

    <style>
        body {
            background-color: <?= ($theme == 'dark') ? '#000' : '#fff'; ?>;
            color: <?= ($theme == 'dark') ? '#fff' : '#000'; ?>;
            font-family: Arial;
        }
    </style>
</head>
<body>

<h1><?= $message ?></h1>

<p>Current Theme: <b><?= $theme ?></b></p>

<a href="preference.php">Change Theme</a>

<br><br>

<form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>

</body>
</html>