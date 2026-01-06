<?php
    require 'db.php';

    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $sql  = "UPDATE students SET Name=?, Email=?, course=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['course'],
            $id,
        ]);
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Student</title>
    <h2>EDIT STUDENT</h2>
</head>
<body>

<form method="POST">
    Name: <input type="text" name="name" value="<?php echo $student['Name']; ?>"><br><br>
    Email: <input type="email" name="email" value="<?php echo $student['Email']; ?>"><br><br>
    Course: <input type="text" name="course" value="<?php echo $student['course']; ?>"><br><br>
    <button type="submit">Update</button>
</form>

</body>
</html>
