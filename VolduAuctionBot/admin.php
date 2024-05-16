<?php
include_once "php/config.php";

include_once "php/logging.php";

include_once "php/DBHandler.php";

// Инициализация объекта для работы с базой данных
$dbHandler = new Database($host, $DBName, $username, $password); // $config - это массив с настройками базы данных

// Обработка формы добавления нового лота
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pictureURL = $_POST['pictureURL'] ?? '';
    $minCost = $_POST['minCost'] ?? 0;
    $author = $_POST['author'] ?? '';

    // Добавление нового лота в базу данных
    $dbHandler->addNewLot($pictureURL, $minCost, $author);

    // Перенаправление на ту же страницу после добавления лота
    header('Location: /admin.php');
    exit;
}

// Получение списка всех лотов
$lots = $dbHandler->getAllLots();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Panel</h1>

        <!-- Форма для добавления нового лота -->
        <form method="post">
            <div class="form-group">
                <label for="pictureURL">Picture URL:</label>
                <input type="text" class="form-control" id="pictureURL" name="pictureURL">
            </div>
            <div class="form-group">
                <label for="minCost">Minimum Cost:</label>
                <input type="number" class="form-control" id="minCost" name="minCost" step="0.01">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author">
            </div>
            <button type="submit" class="btn btn-primary">Add Lot</button>
        </form>

        <!-- Таблица с существующими лотами -->
        <h2 class="mt-4">Existing Lots</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Picture URL</th>
                    <th>Minimum Cost</th>
                    <th>Author</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lots as $lot): ?>
                    <tr>
                        <td><?php echo $lot['id']; ?></td>
                        <td><?php echo $lot['pictureURL']; ?></td>
                        <td><?php echo $lot['minCost']; ?></td>
                        <td><?php echo $lot['author']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>