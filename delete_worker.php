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

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo 'Некорректный ID';
}

$id = $_GET['id'];
$delete = $conn->prepare("DELETE FROM workers WHERE id = :id");
$delete->execute([':id' => $id]);

if ($delete->rowCount() > 0) {
    header('Location: index.php');
    exit;
} else {
    echo "Работник с ID $id не найден!";
}
