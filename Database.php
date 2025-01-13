<?php
$host = "localhost"; // 数据库主机
$db_name = "eys"; // 数据库名称
$username = "root"; // 数据库用户名
$password = ""; // 数据库密码

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>
