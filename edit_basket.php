<?php
include_once 'database.php'; // 引入数据库连接

// 检查是否提供了要编辑的礼篮ID
if (!isset($_GET['id'])) {
    echo "<script>alert('Basket ID not provided.'); window.location.href='index.php';</script>";
    exit();
}

$basket_id = $_GET['id'];

// 查询特定礼篮的信息
try {
    $sql = "SELECT * FROM gift_baskets WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $basket_id);
    $stmt->execute();
    $basket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$basket) {
        echo "<script>alert('Basket not found.'); window.location.href='index.php';</script>";
        exit();
    }
} catch (Exception $e) {
    echo "<script>alert('Unable to retrieve basket information.');</script>";
}

// 更新操作
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $stock_in = $_POST['stock_in'];
    $reserve = $_POST['reserve'];

    // 处理照片上传
    $new_image_path = $basket['image_path']; // 默认使用原来的照片路径
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '') {
        $target_dir = "uploads/"; // 上传文件的目录
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // 检查文件类型
        if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $new_image_path = $target_file;
            } else {
                echo "<script>alert('Error uploading image.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPG, JPEG, PNG & GIF are allowed.');</script>";
        }
    }
    
    try {
        // 更新数据库中的记录
        $sql_update = "UPDATE gift_baskets SET name = :name, price = :price, quantity = :quantity, stock_in = :stock_in, reserve = :reserve, image_path = :image_path WHERE id = :id";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':name', $name);
        $stmt_update->bindParam(':price', $price);
        $stmt_update->bindParam(':quantity', $quantity);
        $stmt_update->bindParam(':stock_in', $stock_in);
        $stmt_update->bindParam(':reserve', $reserve);
        $stmt_update->bindParam(':image_path', $new_image_path);
        $stmt_update->bindParam(':id', $basket_id);
        
        if ($stmt_update->execute()) {
            echo "<script>alert('Basket information updated successfully!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Update failed!');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error during update operation.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gift Basket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --success: #2ecc71;
            --danger: #e74c3c;
            --background: #f8f9fa;
        }

        body {
            background-color: var(--background);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 800px;
            margin-top: 2rem;
        }

        .edit-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: none;
        }

        h1 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-group label i {
            margin-right: 8px;
            color: var(--accent);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(52,152,219,0.25);
        }

        .current-image {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .current-image img {
            max-width: 200px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .current-image img:hover {
            transform: scale(1.05);
        }

        .form-control-file {
            padding: 10px;
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-control-file:hover {
            border-color: var(--accent);
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: var(--accent);
            border: none;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52,152,219,0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            border: none;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(127,140,141,0.3);
        }

        .preview-container {
            margin-top: 1rem;
            display: none;
        }

        .preview-image {
            max-width: 200px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            .edit-card {
                padding: 1.5rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .current-image img {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .edit-card {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }
        }

        /* 动画效果 */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading:after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin: -10px 0 0 -10px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-card">
            <h1><i class="fas fa-edit mr-2"></i>Edit Gift Basket</h1>
            <form method="POST" enctype="multipart/form-data" id="editBasketForm">
                <div class="form-group">
                    <label><i class="fas fa-gift"></i>Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo htmlspecialchars($basket['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tag"></i>Price</label>
                    <input type="number" class="form-control" id="price" name="price" 
                           value="<?php echo htmlspecialchars($basket['price']); ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-boxes"></i>Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="<?php echo htmlspecialchars($basket['quantity']); ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i>Stock-in Date</label>
                    <textarea class="form-control" name="stock_in" rows="3" required><?php echo htmlspecialchars($basket['stock_in']); ?></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-bookmark"></i>Customer Reserve</label>
                    <input type="number" class="form-control" id="reserve" name="reserve" 
                           value="<?php echo htmlspecialchars($basket['reserve']); ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-image"></i>Current Photo</label>
                    <div class="current-image">
                        <?php if ($basket['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($basket['image_path']); ?>" 
                                 alt="Current Basket Photo" class="img-fluid">
                        <?php else: ?>
                            <p class="text-muted">No image available.</p>
                        <?php endif; ?>
                    </div>
                    <label><i class="fas fa-upload"></i>Upload New Photo</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <div class="preview-container">
                        <img src="" alt="Preview" class="preview-image">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-between flex-wrap">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Update Basket
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // 图片预览
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('.preview-container').show();
                        $('.preview-image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // 表单提交动画
            $('#editBasketForm').submit(function() {
                $('button[type="submit"]').addClass('loading');
            });

            // 输入验证动画
            $('.form-control').on('invalid', function() {
                $(this).addClass('shake').delay(500).queue(function() {
                    $(this).removeClass('shake').dequeue();
                });
            });

            // 数字输入框的动态验证
            $('input[type="number"]').on('input', function() {
                if ($(this).val() < 0) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>
