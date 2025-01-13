<?php
include_once 'database.php'; // 引入数据库连接

// 检查是否传递了 basket_id
if (isset($_GET['id'])) {
    $basket_id = $_GET['id'];

    // 查询特定礼篮的进货记录
    try {
        $sql = "SELECT * FROM stock_in WHERE basket_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $basket_id);
        $stmt->execute();
        $stock_in_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("无法获取进货记录：" . $e->getMessage());
    }

    // 设置 Excel 文件头
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="stock_in_records.xls"');

    // 打印表头
    echo "ID\tBasket ID\t数量\t进货时间\n";

    // 打印数据
    foreach ($stock_in_records as $record) {
        echo $record['id'] . "\t" . $record['basket_id'] . "\t" . $record['quantity'] . "\t" . $record['stock_in_time'] . "\n";
    }
    exit();
} else {
    die("未指定礼篮 ID。");
}
?>
