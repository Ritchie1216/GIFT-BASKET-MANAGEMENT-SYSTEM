<?php
include_once 'database.php'; // 引入数据库连接

// 处理进货提交
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stock_in'])) {
    $basket_id = $_POST['basket_id'];
    $quantity = $_POST['quantity'];

    try {
        // 插入新进货记录
        $sql = "INSERT INTO stock_in (basket_id, quantity) VALUES (:basket_id, :quantity)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':basket_id', $basket_id);
        $stmt->bindParam(':quantity', $quantity);

        if ($stmt->execute()) {
            echo "<script>alert('进货记录添加成功！');</script>";
            header("Location: index.php"); // 重定向回index.php
            exit();
        } else {
            echo "<script>alert('进货记录添加失败！');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('更新操作出错。');</script>";
    }
}

// 查询特定礼篮的进货记录
if (isset($_GET['id'])) {
    $basket_id = $_GET['id'];

    try {
        $sql = "SELECT * FROM stock_in WHERE basket_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $basket_id);
        $stmt->execute();
        $stock_in_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 计算总数量
        $total_quantity = 0;
        foreach ($stock_in_records as $record) {
            $total_quantity += $record['quantity'];
        }

    } catch (Exception $e) {
        echo "<script>alert('无法获取进货记录。');</script>";
        $total_quantity = 0;
    }
} else {
    $stock_in_records = [];
    $total_quantity = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock In Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>进货记录</h1>
        <a href="export.php?id=<?php echo $basket_id; ?>" class="btn btn-primary mb-3">
    <i class="bi bi-file-excel-fill"></i> 导出为 Excel
</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Basket ID</th>
                    <th>数量</th>
                    <th>进货时间</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($stock_in_records) > 0): ?>
                    <?php foreach ($stock_in_records as $record): ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['basket_id']; ?></td>
                            <td><?php echo $record['quantity']; ?></td>
                            <td><?php echo $record['stock_in_time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">没有找到进货记录。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 显示总数量 -->
        <div class="mt-3">
            <h4>总数量：<?php echo $total_quantity; ?></h4>
        </div>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-bucket-fill"></i>返回</a>
    </div>
</body>
</html>
