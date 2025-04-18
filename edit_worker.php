<?php
$dsn = 'mysql:host=localhost;dbname=so_sta1';
$username = 'sta1';
$password = 'dt0fIDWv9X';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Подключение успешно!";
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

if(!isset($_GET['id'])) {
    echo 'Некорректный ID';
    exit;
}
$id = $_GET['id'];
try {
    if (isset($_POST['name']) && isset($_POST['age']) && isset($_POST['salary'])) {
        $name = htmlspecialchars($_POST['name']);
        $age = htmlspecialchars($_POST['age']);
        $salary = htmlspecialchars($_POST['salary']);
        $edit = $conn->prepare("UPDATE workers SET name = :name, age = :age, salary = :salary WHERE id = :id");
        $edit->execute([':name' => $name, ':age' => $age, ':salary' => $salary, ':id' => $id]);
        if ($edit->rowCount() > 0) {
            echo 'Worker successfully updated!';
        } else {
            echo 'Worker not updated!';
        }
    }
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
function inputs($inputName) {
    $value = isset($_POST[$inputName]) ? htmlspecialchars($_POST[$inputName]) : '';
    echo '<input type="text" name="' . $inputName . '" value="' . $value . '" />';
}
?>
<form action="edit_worker.php?id=<?= urlencode($id) ?>" method="post">
    <h3>Редактировать работника</h3>
    <?php
    echo '<p>Name</p>';
    inputs('name');
    echo '<p>Age</p>';
    inputs('age');
    echo '<p>Salary</p>';
    inputs('salary');
    ?>
    <input type="submit" value="edit" />
</form>
<a href="index.php">Go back</a>