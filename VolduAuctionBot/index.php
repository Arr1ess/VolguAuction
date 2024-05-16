<?php
include_once "php/config.php";

include_once "php/logging.php";

include_once "php/DBHandler.php";

// Инициализация объекта для работы с базой данных
$dbHandler = new Database($host, $DBName, $username, $password);

if ($dbHandler) {
	logging("Подключение к базе прошло успешно");
} else {
	logging("Не удалось подключиться к базе данных");
}

// Функция для установки нового лота по его ID
function setNewLot($lotId)
{
	global $dbHandler;
	// Очистка массива со ставками
	$bids = [];
	// Установка таймера на 60 секунд (1 минута)
	$timer = 60;
	// Получение информации о лоте из базы данных
	$lot = $dbHandler->getLotById($lotId);
	// Возвращаем информацию о лоте и таймер
	return ['lot' => $lot, 'bids' => $bids, 'timer' => $timer];
}

// Пример использования функции установки нового лота
$lotData = setNewLot(1); // Замените 1 на ID нужного лота
$lot = $lotData['lot'];
$bids = $lotData['bids'];
$timer = $lotData['timer'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Auction Site</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container mt-5">
		<h1 class="text-center mb-4">Auction Table</h1>
		<!-- Отображение информации о лоте -->
		<div class="mb-4">
			<h2>Lot Information</h2>
			<p><strong>ID:</strong> <?php echo $lot['id']; ?></p>
			<p><strong>Picture URL:</strong> <?php echo $lot['pictureURL']; ?></p>
			<p><strong>Min Cost:</strong> <?php echo $lot['minCost']; ?></p>
			<p><strong>Author:</strong> <?php echo $lot['author']; ?></p>
		</div>
		<!-- Отображение таблицы ставок -->
		<table class="table">
			<thead>
				<tr>
					<th>User</th>
					<th>Bid</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($bids as $index => $bid): ?>
					<tr <?php if ($index === 0)
						echo 'class="table-success"'; ?>>
						<td><?php echo $bid['user']; ?></td>
						<td><?php echo $bid['bid']; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- Отображение таймера -->
		<div id="timer" class="mb-4">
			<h2>Time Left: <span id="time"><?php echo $timer; ?></span> seconds</h2>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script>
		// Функция для обновления таймера
		function updateTimer() {
			let timeElement = document.getElementById('time');
			let timer = parseInt(timeElement.textContent);
			timer--;
			timeElement.textContent = timer;
			if (timer <= 0) {
				clearInterval(timerInterval);
				timeElement.classList.add('red');
			}
		}

		// Установка таймера на 60 секунд (1 минута)
		let timerInterval = setInterval(updateTimer, 1000);
	</script>
</body>

</html>