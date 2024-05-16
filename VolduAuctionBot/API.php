<?php
// Пример обработки новой ставки через API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из POST запроса
    $user = $_POST['user'] ?? '';
    $bid = $_POST['bid'] ?? 0;

    // Здесь вы можете добавить логику для сохранения ставки в базу данных или в файл
    // Например, вы можете сохранить данные в файл JSON
    $data = [
        'user' => $user,
        'bid' => $bid,
    ];

    // Отправляем ответ обратно клиенту
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}