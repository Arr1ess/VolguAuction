<?php
class Database {
	private $pdo;

	public function __construct($host, $db, $user, $pass, $charset = 'utf8mb4') {
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES   => false,
			];

			try {
					$this->pdo = new PDO($dsn, $user, $pass, $options);
					$this->checkTables();
			} catch (\PDOException $e) {
					throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}
	}

	private function checkTables() {
			$tables = [
					'users' => "CREATE TABLE IF NOT EXISTS users (
							id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							name VARCHAR(255) NOT NULL,
							tgID VARCHAR(255) NOT NULL,
							balance DECIMAL(10,2) NOT NULL DEFAULT 0
					)",
					'lots' => "CREATE TABLE IF NOT EXISTS lots (
							id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							pictureURL VARCHAR(255),
							minCost DECIMAL(10,2) NOT NULL DEFAULT 0,
							author VARCHAR(255)
					)",
					'transactions' => "CREATE TABLE IF NOT EXISTS transactions (
							id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
							from_user INT(11) UNSIGNED,
							to_user INT(11) UNSIGNED,
							value DECIMAL(10,2) NOT NULL,
							event VARCHAR(255),
							FOREIGN KEY (from_user) REFERENCES users(id),
							FOREIGN KEY (to_user) REFERENCES users(id)
					)"
			];

			foreach ($tables as $table => $sql) {
					$this->pdo->exec($sql);
			}
	}
}


$db = new Database($host, $DBName, $username, $password);

if($db){
	logging("Подключение к базе прошло успешно");
}else{
	logging("Не удалось подключиться к базе данных");
}