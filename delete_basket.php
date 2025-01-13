<?php
include_once 'Database.php';

// 添加确认对话框的 HTML 和样式
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Gift Basket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --danger: #e74c3c;
            --background: #f8f9fa;
        }

        body {
            background-color: var(--background);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 确认对话框样式 */
        .delete-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            max-width: 90%;
            width: 400px;
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .modal-icon {
            font-size: 3rem;
            color: var(--danger);
            margin-bottom: 1rem;
        }

        .modal-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .modal-body {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
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

        .btn-danger {
            background: var(--danger);
            border: none;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231,76,60,0.3);
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

        /* 动画 */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { 
                transform: translate(-50%, -60%);
                opacity: 0;
            }
            to { 
                transform: translate(-50%, -50%);
                opacity: 1;
            }
        }

        /* 响应式设计 */
        @media (max-width: 576px) {
            .modal-content {
                width: 90%;
                padding: 1.5rem;
            }

            .modal-icon {
                font-size: 2.5rem;
            }

            .btn {
                padding: 0.5rem 1.5rem;
                font-size: 0.9rem;
            }

            .modal-title {
                font-size: 1.2rem;
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

<?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // 显示确认对话框
    echo '<div class="delete-modal" id="deleteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4 class="modal-title">确认删除</h4>
                </div>
                <div class="modal-body">
                    <p>您确定要删除这个礼篮吗？此操作无法撤销。</p>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-secondary" onclick="cancelDelete()">
                        <i class="fas fa-times"></i>取消
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $delete_id . ')">
                        <i class="fas fa-trash-alt"></i>删除
                    </button>
                </div>
            </div>
          </div>';
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // 显示确认对话框
    $(document).ready(function() {
        $('#deleteModal').show();
    });

    // 取消删除
    function cancelDelete() {
        $('#deleteModal').fadeOut(300, function() {
            window.location.href = 'index.php';
        });
    }

    // 确认删除
    function confirmDelete(id) {
        $('.btn-danger').addClass('loading');
        
        $.ajax({
            url: 'delete_process.php',
            type: 'POST',
            data: { delete_id: id },
            success: function(response) {
                window.location.href = 'index.php';
            },
            error: function() {
                alert('删除操作失败，请重试。');
                $('.btn-danger').removeClass('loading');
            }
        });
    }
</script>
</body>
</html>
