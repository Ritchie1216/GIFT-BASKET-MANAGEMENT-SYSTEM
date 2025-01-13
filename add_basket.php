<?php
include_once 'database.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $stock_in = $_POST['stock_in']; // Stock-in date
    $reserve = $_POST['reserve']; // Reserve

    // File upload handling
    $target_dir = "uploads/"; // Upload directory
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('The file is not an image.');</script>";
        $upload_ok = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        echo "<script>alert('Sorry, the file is too large.');</script>";
        $upload_ok = 0;
    }

    // Allowed file formats
    if (!in_array($image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $upload_ok = 0;
    }

    // Upload file
    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $sql = "INSERT INTO gift_baskets (name, price, quantity, image_path, stock_in, reserve) VALUES (:name, :price, :quantity, :image_path, :stock_in, :reserve)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':image_path', $target_file);
            $stmt->bindParam(':stock_in', $stock_in); // Stock-in date
            $stmt->bindParam(':reserve', $reserve); // Reserve

            if ($stmt->execute()) {
                // Redirect to index.php after successful addition
                header("Location: index.php");
                exit(); // Stop script after redirection
            } else {
                echo "<script>alert('Failed to add gift basket.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading the file.');</script>";
        }
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Year Gift Basket</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --success: #2ecc71;
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background: white;
            padding: 2rem;
            margin-bottom: 2rem;
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
        }

        .form-group label {
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 0.5rem;
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

        .btn-primary {
            background: var(--accent);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52,152,219,0.3);
        }

        /* 文件上传预览 */
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

            .card {
                padding: 1.5rem;
            }

            .btn-primary {
                width: 100%;
                padding: 0.6rem;
            }

            .form-control {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .card {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }
        }

        /* 加载动画 */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="mb-4">Add New Gift Basket</h1>
            <form action="add_basket.php" method="post" enctype="multipart/form-data" id="addBasketForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-gift mr-2"></i>Name:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-tag mr-2"></i>Price:</label>
                    <input type="text" class="form-control" name="price" required>
                </div>
                <div class="form-group">
                    <label for="quantity"><i class="fas fa-boxes mr-2"></i>Quantity:</label>
                    <input type="number" class="form-control" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="stock_in"><i class="fas fa-calendar-alt mr-2"></i>Stock-in Date:</label>
                    <textarea class="form-control" name="stock_in" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="reserve"><i class="fas fa-bookmark mr-2"></i>Reserve:</label>
                    <input type="text" class="form-control" name="reserve" required>
                </div>
                <div class="form-group">
                    <label for="image"><i class="fas fa-image mr-2"></i>Upload Image:</label>
                    <input type="file" class="form-control-file" name="image" id="imageInput" required>
                    <div class="preview-container mt-3">
                        <img src="" alt="Preview" class="preview-image">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>Add Gift Basket
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // 图片预览
            $('#imageInput').change(function() {
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
            $('#addBasketForm').submit(function() {
                $('button[type="submit"]').addClass('loading');
            });

            // 输入验证动画
            $('.form-control').on('invalid', function() {
                $(this).addClass('shake').delay(500).queue(function() {
                    $(this).removeClass('shake').dequeue();
                });
            });
        });
    </script>
</body>
</html>
