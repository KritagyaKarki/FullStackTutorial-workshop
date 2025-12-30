<?php
    require 'db.php';

    try {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name   = $_POST['name'] ?? '';
            $email  = $_POST['email'] ?? '';
            $course = $_POST['course'] ?? '';

            $sql  = "INSERT INTO students (name, email, course) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $course]);

            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Failed to add student: " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <h2>ADD STUDENT</h2>

</head>
<body>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Course: <input type="text" name="course" required><br><br>
    <button type="submit">Add Student</button>
</form>

<br>
<a href="index.php">View Students</a>

</body>
</html>
