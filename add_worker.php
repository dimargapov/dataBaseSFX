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

try {
if (isset($_POST['name']) && isset($_POST['age']) && isset($_POST['salary'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $salary = $_POST['salary'];
    $add = $conn->prepare("INSERT INTO workers (name, age, salary) VALUES (:name, :age, :salary)");
    $add->execute([':name' => $name, ':age' => $age, ':salary' => $salary]);
    if ($add->rowCount() > 0) {
        echo 'Worker successfully added!';
    } else {
        echo 'Worker not added!';
    }
}
}
 catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
}
?>

<h3>Добавить работника:</h3>
<form action="add_worker.php" method="post">
    <p>Name<br>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" /></p>
    <p>Age<br>
        <input type="number" name="age" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>" /></p>
    <p>Salary<br>
        <input type="number" name="salary" value="<?php echo isset($_POST['salary']) ? htmlspecialchars($_POST['salary']) : ''; ?>" /></p>
    <input type="submit" value="Add worker" />
</form>

<br><br>

<h3>Форма, сделанная с помощью функции</h3>
<?php function inputs($inputName) {
    $value = isset($_POST[$inputName]) ? htmlspecialchars($_POST[$inputName]) : '';
    echo '<input type="text" name="' . $inputName . '" value="' . $value . '" />';
}
?>
<form action="add_worker.php" method="post">
    <h3>Добавить работника(new)</h3>
    <?php
    echo '<p>Name</p>';
    inputs('name');
    echo '<p>Age</p>';
    inputs('age');
    echo '<p>Salary</p>';
    inputs('salary');
    ?>
    <input type="submit" value="add" />
</form>
<a href="index.php">Go back</a>
