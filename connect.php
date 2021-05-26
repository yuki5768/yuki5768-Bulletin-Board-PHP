<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname={db_name};charset=utf8', '{user_name}', '{password}');
} catch (PDOExeption $e) {
	echo '接続エラー' . $e->getMessage();
	exit();
}
