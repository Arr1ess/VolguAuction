<?php
include_once "php/logging.php";
include_once "php/config.php";
include_once "php/DBHandler.php";



// Пример данных ставок
$bids = [
	['user' => 'User 1', 'bid' => 120],
	['user' => 'User 2', 'bid' => 150],
	['user' => 'User 3', 'bid' => 200],
	// Добавьте свои ставки здесь
];

// Сортировка ставок по убыванию
usort($bids, function ($a, $b) {
	return $b['bid'] <=> $a['bid'];
});

// Ограничение вывода до 10 ставок
$bids = array_slice($bids, 0, 10);
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
	<style>
		.table-success {
			font-weight: bold;
			font-size: 1.2em;
		}
	</style>
	<style>
		#timer {
			font-size: 2em;
			color: black inherit;
		}

		.red {
			color: red;
		}
	</style>
	<div id="timer"></div>
	<div class="container mt-5">
		<h1 class="text-center mb-4">Auction Table</h1>
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
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<script>
		let timerElement = document.getElementById('timer');
		let timerValue = 10; // начальное значение таймера в секундах
		let timerInterval;

		function setTimer(seconds) {
			clearInterval(timerInterval); // Очищаем предыдущий интервал, если он существует
			timerValue = seconds;
			updateTimerDisplay();
			if (timerValue > 0) {
				timerInterval = setInterval(decreaseTimer, 1000);
			}
		}

		function decreaseTimer() {
			timerValue--;
			updateTimerDisplay();
			if (timerValue <= 0) {
				clearInterval(timerInterval);
			}
		}

		function addTime(seconds) {
			timerValue += seconds;
			updateTimerDisplay();
			if (timerValue > 0 && !timerInterval) {
				timerInterval = setInterval(decreaseTimer, 1000);
			}
		}

		function updateTimerDisplay() {
			timerElement.textContent = timerValue;
			if (timerValue <= 5) {
				timerElement.classList.add('red');
			} else {
				timerElement.classList.remove('red');
			}
		}

		// Установка начального значения таймера
		setTimer(10);

		// Пример добавления времени
		// addTime(5);
	</script>

</body>

</html>