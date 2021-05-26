<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=xxxxx;charset=utf8', 'xxxxx', 'xxxxx');
} catch (PDOExeption $e) {
	echo '接続エラー' . $e->getMessage();
	exit();
}
