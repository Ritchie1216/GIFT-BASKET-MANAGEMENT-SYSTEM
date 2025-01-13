<?php
include_once 'Database.php';

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    
    try {
        // 删除数据库中的记录
        $sql_delete = "DELETE FROM gift_baskets WHERE id = :id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);

        if ($stmt_delete->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => '删除失败']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '无效的请求']);
}
?> 