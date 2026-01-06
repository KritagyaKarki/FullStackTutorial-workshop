<?php
    require 'db.php';

    $sql      = "SELECT * FROM students";
    $stmt     = $pdo->query($sql);
    $students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>


    <title>View Students</title>

</head>
<body>

<h2>STUDENT LIST</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

<?php foreach ($students as $student): ?>
<tr>
    <td><?php echo $student['Name']; ?></td>
    <td><?php echo $student['Email']; ?></td>
    <td><?php echo $student['course']; ?></td>
    <td><a href="edit.php?id=<?php echo $student['Id']; ?>">Edit</a></td>
    <td><a href="delete.php?id=<?php echo $student['Id']; ?>">Delete</a></td>
</tr>
<?php endforeach; ?>

</table>

<br>
<a href="create.php">Add New Student</a>

</body>
</html>
