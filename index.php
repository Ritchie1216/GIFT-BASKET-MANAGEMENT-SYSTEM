<?php
include_once 'database.php'; // 引入数据库连接
include_once 'header.php'; // 加载头部和布局

try {
    // 查询数据库中的所有礼篮
    $sql = "SELECT * FROM gift_baskets";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $gift_baskets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<script>alert('无法获取礼篮记录。');</script>";
}

try {
    // 基础查询语句
    $sql = "SELECT * FROM gift_baskets";
    
    // 检查是否有搜索关键词
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        
        // 检查搜索关键词是否是数字（用于价格搜索）
        if (is_numeric($search)) {
            $sql .= " WHERE price = :search OR name LIKE :search_text";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':search', $search); // 精确匹配价格
            $search_text = "%" . $search . "%"; // 模糊匹配名称
            $stmt->bindParam(':search_text', $search_text);
        } else {
            // 只根据名称搜索
            $sql .= " WHERE name LIKE :search";
            $stmt = $conn->prepare($sql);
            $search_param = "%" . $search . "%";
            $stmt->bindParam(':search', $search_param);
        }
    } else {
        // 没有搜索关键词时，查询所有记录
        $stmt = $conn->prepare($sql);
    }

    // 执行查询
    $stmt->execute();
    $gift_baskets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<script>alert('无法获取礼篮记录。');</script>";
}

// 处理销售提交
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sales'])) {
    $sales_id = $_POST['sales_id'];
    $sales_quantity = $_POST['sales_quantity'];

    try {
        // 更新数据库中的数量
        $sql_update = "UPDATE gift_baskets SET quantity = quantity - :sales_quantity WHERE id = :id AND quantity >= :sales_quantity";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':sales_quantity', $sales_quantity);
        $stmt_update->bindParam(':id', $sales_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('销售数量更新成功！');</script>";
            header("Location: index.php"); // 重定向回index.php
            exit();
        } else {
            echo "<script>alert('销售数量更新失败！');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('更新操作出错。');</script>";
    }
}

// 处理添加数量提交
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $add_id = $_POST['add_id'];
    $add_quantity = $_POST['add_quantity'];

    try {
        // 更新数据库中的数量
        $sql_add = "UPDATE gift_baskets SET quantity = quantity + :add_quantity WHERE id = :id";
        $stmt_add = $conn->prepare($sql_add);
        $stmt_add->bindParam(':add_quantity', $add_quantity);
        $stmt_add->bindParam(':id', $add_id);

        if ($stmt_add->execute()) {
            echo "<script>alert('数量添加成功！');</script>";
            header("Location: index.php"); // 重定向回index.php
            exit();
        } else {
            echo "<script>alert('数量添加失败！');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('更新操作出错。');</script>";
    }
}

// 处理进货记录提交
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stock_in'])) {
    $basket_id = $_POST['basket_id'];
    $stock_in_time = $_POST['stock_in_time']; // 用户输入的时间
    $stock_in_quantity = $_POST['stock_in_quantity'];

    try {
        // 插入新的来货记录
        $sql_stock_in = "INSERT INTO stock_in (basket_id, stock_in_time, quantity) VALUES (:basket_id, :stock_in_time, :quantity)";
        $stmt_stock_in = $conn->prepare($sql_stock_in);
        $stmt_stock_in->bindParam(':basket_id', $basket_id);
        $stmt_stock_in->bindParam(':stock_in_time', $stock_in_time);
        $stmt_stock_in->bindParam(':quantity', $stock_in_quantity);

        if ($stmt_stock_in->execute()) {
            // 更新礼篮数量
            $sql_update_basket = "UPDATE gift_baskets SET quantity = quantity + :quantity WHERE id = :id";
            $stmt_update_basket = $conn->prepare($sql_update_basket);
            $stmt_update_basket->bindParam(':quantity', $stock_in_quantity);
            $stmt_update_basket->bindParam(':id', $basket_id);
            $stmt_update_basket->execute();

            echo "<script>alert('来货记录添加成功！');</script>";
            header("Location: index.php"); // 重定向回index.php
            exit();
        } else {
            echo "<script>alert('来货记录添加失败！');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('来货记录操作出错。');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新年礼篮管理系统</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background like YouTube */
        }

        .navbar {
            background-color: #282828; /* Dark navbar similar to YouTube */
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff;
        }

        .nav-link:hover {
            color: #d3d3d3; /* Subtle hover effect */
        }

        h1 {
            color: #282828;
        }

        table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for a clean look */
        }

        th,
        td {
            vertical-align: middle;
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
            color: #282828; /* Light gray for table header */
            font-weight: bold;
        }

        .form-control,
        .btn {
            border-radius: 6px; /* Softer rounded edges */
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
        }

        .btn-success,
        .btn-info,
        .btn-warning,
        .btn-danger,
        .btn-primary {
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .btn-primary {
            background-color: #cc0000; /* YouTube red for primary actions */
            border-color: #cc0000;
        }

        .btn-primary:hover {
            background-color: #b00000; /* Darker red on hover */
            border-color: #b00000;
        }

        .img-thumbnail {
            border-radius: 4px;
            max-height: 100px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .img-thumbnail:hover {
            transform: scale(1.05); /* Subtle zoom on hover */
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #282828;
            color: white;
        }

        .table th {
            background-color: #f1f1f1;
            color: #282828;
        }

        .low-stock {
            color: #cc0000; /* Red color for low stock warning */
        }

        .container {
            max-width: 1200px;
            margin-top: 40px;
        }

        #search {
            max-width: 400px;
        }

        /* Ensure responsive design for the table and form elements */
        @media (max-width: 768px) {
            table {
                font-size: 12px; /* Adjust font size for small screens */
            }

            .img-thumbnail {
                max-height: 80px; /* Reduce image size on smaller screens */
            }

            .form-control,
            .btn {
                font-size: 12px; /* Adjust font size for small screens */
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        @media (max-width: 576px) {
            /* Additional tweaks for mobile devices */
            .table th,
            .table td {
                font-size: 10px; /* Further reduce text size on very small screens */
            }

            .form-group label {
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
                padding: 6px 12px;
            }
        }

        /* Additional styling for actions column */
        .actions-column {
            width: 250px; /* Increase width for Actions column */
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <!-- Display table and form for gift basket management -->
        <h1 class="mb-4">New Year Gift Basket Management System </h1>

        <form action="index.php" method="GET" class="mb-4">
            <div class="form-group">
                <label for="search">Search by Basket Name or Price:</label>
                <input type="text" name="search" id="search" class="form-control" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                    placeholder="输入礼篮名称或价格">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive"> <!-- Ensure the table scrolls on small screens -->
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                       
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Customer Reserve</th>
                        <th>Balance</th> <!-- Added Balance column -->
                        <th>Image</th>
                        <th>Sales</th>
                        <th>Add Quantity</th>
                        <th>Stock In</th> <!-- Added Stock In column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($gift_baskets) > 0): ?>
                    <?php foreach ($gift_baskets as $basket): ?>
                    <tr>
                
                        <td><?php echo $basket['name']; ?></td>
                        <td><?php echo $basket['price']; ?></td>
                        <td class="<?php echo $basket['quantity'] < 5 ? 'low-stock' : ''; ?>">
                            <?php echo $basket['quantity'] < 5 ? 'Low Stock ('.$basket['quantity'].')' : $basket['quantity']; ?>
                        </td>
                        <td><?php echo $basket['reserve']; ?></td>
                        <td>
                            <?php $balance = $basket['quantity'] - $basket['reserve']; ?>
                            <span style="<?php echo $balance < 0 ? 'color:red;' : ''; ?>"><?php echo $balance; ?></span>
                        </td>
                        <td>
                            <img src="<?php echo $basket['image_path']; ?>" alt="<?php echo $basket['name']; ?>"
                                class="img-thumbnail" onclick="openModal('<?php echo $basket['image_path']; ?>')">
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="sales_id" value="<?php echo $basket['id']; ?>">
                                <input type="number" name="sales_quantity" min="1" max="<?php echo $basket['quantity']; ?>"
                                    required placeholder="数量" class="form-control">
                                <button type="submit" name="sales" class="btn btn-success btn-sm">Sales</button>
                            </form>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="add_id" value="<?php echo $basket['id']; ?>">
                                <input type="number" name="add_quantity" min="1" required placeholder="stock_in" class="form-control">
                                <button type="submit" name="add" class="btn btn-primary btn-sm">stock_in</button>
                            </form>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="basket_id" value="<?php echo $basket['id']; ?>">
                                <input type="datetime-local" name="stock_in_time" required class="form-control mt-2">
                                <input type="number" name="stock_in_quantity" min="1" required placeholder="Stock in"
                                    class="form-control mt-2">
                                <button type="submit" name="stock_in" class="btn btn-warning btn-sm mt-2">Stock in</button>
                            </form>
                        </td>
                        <td>
                            <a href="edit_basket.php?id=<?php echo $basket['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="delete_basket.php?delete_id=<?php echo $basket['id']; ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('您确定要删除这个礼篮吗？');">Delete</a>
                            <a href="stock_in.php?id=<?php echo $basket['id']; ?>" class="btn btn-secondary btn-sm">Stock In Records</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10">"No gift basket records found."</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Basket Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function openModal(imagePath) {
            document.getElementById("modalImage").src = imagePath;
            $('#imageModal').modal('show');
        }
    </script>
</body>

</html>
