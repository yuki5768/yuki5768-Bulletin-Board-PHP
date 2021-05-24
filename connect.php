<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=procir_TAKEDA379;charset=utf8', 'TAKEDA379', '4p3kik4ggx');
} catch (PDOExeption $e) {
	echo '接続エラー' . $e->getMessage();
	exit();
}
