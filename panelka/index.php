<?php
require_once '../config.php';

// Обработка форм
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $pdo->prepare("INSERT INTO pages (page_id, title, description, file_name, file_size, file_os, file_memory, download_speed, download_link, file_source, file_control, file_password, file_extract) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['page_id'],
                    $_POST['title'],
                    $_POST['description'],
                    $_POST['file_name'],
                    $_POST['file_size'],
                    $_POST['file_os'],
                    $_POST['file_memory'],
                    $_POST['download_speed'],
                    $_POST['download_link'],
                    $_POST['file_source'],
                    $_POST['file_control'],
                    $_POST['file_password'],
                    $_POST['file_extract']
                ]);
                $message = "Страница успешно добавлена!";
                break;
                
            case 'edit':
                $stmt = $pdo->prepare("UPDATE pages SET title=?, description=?, file_name=?, file_size=?, file_os=?, file_memory=?, download_speed=?, download_link=?, file_source=?, file_control=?, file_password=?, file_extract=? WHERE page_id=?");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['description'],
                    $_POST['file_name'],
                    $_POST['file_size'],
                    $_POST['file_os'],
                    $_POST['file_memory'],
                    $_POST['download_speed'],
                    $_POST['download_link'],
                    $_POST['file_source'],
                    $_POST['file_control'],
                    $_POST['file_password'],
                    $_POST['file_extract'],
                    $_POST['page_id']
                ]);
                $message = "Страница успешно обновлена!";
                break;
                
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM pages WHERE page_id = ?");
                $stmt->execute([$_POST['page_id']]);
                $message = "Страница успешно удалена!";
                break;
        }
    }
}

// Получение всех страниц
$stmt = $pdo->query("SELECT * FROM pages ORDER BY page_id");
$pages = $stmt->fetchAll();

// Получение данных для редактирования
$edit_page = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE page_id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_page = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель CMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            font-size: 2rem;
        }
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .form-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea {
            padding: 12px;
            border: 2px solid #e1e8ed;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-warning:hover {
            background: #e67e22;
        }
        
        .table-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e1e8ed;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .form-actions {
            margin-top: 25px;
            display: flex;
            gap: 15px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛠️ Админ панель CMS</h1>
            <p>Управление страницами сайта</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2><?php echo $edit_page ? 'Редактировать страницу' : 'Добавить новую страницу'; ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?php echo $edit_page ? 'edit' : 'add'; ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="page_id">ID страницы (например: p1, p2, p3):</label>
                        <input type="text" id="page_id" name="page_id" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['page_id']) : ''; ?>" 
                               <?php echo $edit_page ? 'readonly' : ''; ?> required>
                    </div>
                    
                    <div class="form-group">
                        <label for="title">Заголовок страницы:</label>
                        <input type="text" id="title" name="title" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['title']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea id="description" name="description" required><?php echo $edit_page ? htmlspecialchars($edit_page['description']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_name">Название файла:</label>
                        <input type="text" id="file_name" name="file_name" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_name']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_size">Размер файла:</label>
                        <input type="text" id="file_size" name="file_size" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_size']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_os">Операционная система:</label>
                        <input type="text" id="file_os" name="file_os" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_os']) : 'Windows'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_memory">Требования к памяти:</label>
                        <input type="text" id="file_memory" name="file_memory" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_memory']) : '2 GB'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="download_speed">Скорость загрузки:</label>
                        <input type="text" id="download_speed" name="download_speed" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['download_speed']) : '1 Мегабайт'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="download_link">Ссылка для скачивания:</label>
                        <input type="url" id="download_link" name="download_link" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['download_link']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_source">Источник файла:</label>
                        <input type="text" id="file_source" name="file_source" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_source']) : 'Файловый сервер'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_control">Контроль безопасности:</label>
                        <input type="text" id="file_control" name="file_control" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_control']) : 'ClamAV'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_password">Пароль:</label>
                        <input type="text" id="file_password" name="file_password" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_password']) : 'Установлен'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_extract">Программа для распаковки:</label>
                        <input type="text" id="file_extract" name="file_extract" 
                               value="<?php echo $edit_page ? htmlspecialchars($edit_page['file_extract']) : 'WinRAR / 7zip'; ?>" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_page ? 'Обновить страницу' : 'Добавить страницу'; ?>
                    </button>
                    <?php if ($edit_page): ?>
                        <a href="index.php" class="btn btn-primary">Отменить редактирование</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="table-section">
            <h2>Список страниц</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Описание</th>
                        <th>Ссылка</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($page['page_id']); ?></td>
                        <td><?php echo htmlspecialchars(substr($page['title'], 0, 50)) . (strlen($page['title']) > 50 ? '...' : ''); ?></td>
                        <td><?php echo htmlspecialchars(substr($page['description'], 0, 100)) . (strlen($page['description']) > 100 ? '...' : ''); ?></td>
                        <td><a href="../?id=<?php echo urlencode($page['page_id']); ?>" target="_blank" class="btn btn-primary">Просмотр</a></td>
                        <td>
                            <div class="actions">
                                <a href="?edit=<?php echo urlencode($page['page_id']); ?>" class="btn btn-warning">Редактировать</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Вы уверены, что хотите удалить эту страницу?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="page_id" value="<?php echo htmlspecialchars($page['page_id']); ?>">
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>