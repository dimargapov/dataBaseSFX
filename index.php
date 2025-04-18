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

$createTable = "CREATE TABLE IF NOT EXISTS workers (
    id INT NOT NULL PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    age INT NOT NULL,
    salary INT NOT NULL
    );";

//$conn->exec($createTable);

$limit = 2;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$data = $conn->prepare("SELECT * FROM workers LIMIT ?, ?");
$data->bindParam(1, $offset, PDO::PARAM_INT);
$data->bindParam(2, $limit, PDO::PARAM_INT);
$data->execute();
$rows = $data->fetchAll();

$totalData = $conn->query("SELECT COUNT(*) FROM workers");
$totalRows = $totalData->fetchColumn();
$totalPages = ceil($totalRows / $limit);

echo "<table border='1'>";
echo "<thead><tr>
        <th>id</th>
        <th>name</th>
        <th>age</th>
        <th>salary</th>
        <th>action</th>
      </tr>
      </thead>
      <tbody>";

foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
    echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
    echo "<td><a href='delete_worker.php?id=".urlencode($row['id']). "'>delete</a>&nbsp&nbsp&nbsp&nbsp&nbsp<a href='edit_worker.php?id=".urlencode($row['id']). "'>edit</a></td>";
    echo "</tr>";
}

echo "</tbody></table>";

for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href=\"?page=$i\">$i</a> ";
    }
}

echo "&nbsp&nbsp&nbsp&nbsp&nbsp<a href='add_worker.php'>Add a worker</a>";


