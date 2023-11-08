<?php
$servername = "localhost";
$username = "ashok";
$password = "123456";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['message'])) {
        $name = $_POST['name'];
        $message = $_POST['message'];
        
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $sql = "UPDATE crudoperation SET name='$name', message='$message' WHERE id=$id";
        } else {
            $sql = "INSERT INTO crudoperation (name, message) VALUES ('$name', '$message')";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        $id_to_delete = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM crudoperation WHERE id = ?");
        $stmt->bind_param("i", $id_to_delete);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    }
}

$name = '';
$message = '';
$id = '';

if (isset($_POST['edit'])) {
    $id_to_edit = $_POST['id'];
    
    $stmt = $conn->prepare("SELECT name, message FROM crudoperation WHERE id = ?");
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $stmt->bind_result($name, $message);
    
    if ($stmt->fetch()) {
        $id = $id_to_edit;
    }
    
    $stmt->close();
}

$result = $conn->query("SELECT * FROM crudoperation");

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crud</title>
</head>
<body>
    <h1>crud operation by PHP</h1>
    <div>
        <form action="index.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <span>Username: </span>
            <input type="text" name="name" value="<?php echo $name ?>"> <br> <br>
            <span>Message: </span>
            <input type="text" name="message" value="<?php echo $message ?>" > <br><br>
            <input type="submit" value="Submit">
        </form>
    </div>

    <h2>Data from Database</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
        <?php foreach($data as $row): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="edit" value="Edit">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
