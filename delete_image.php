<?php
//セッションチェック
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

//ユーザー確認
if (isset($_GET['user_id'])) {
	//DB接続
	require_once('connect.php');
	$sql1 = 'SELECT * FROM users WHERE id = :id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':id', $_GET['user_id']);
	$stmt1->execute();
	$result = $stmt1->fetch();

	//プロフィール画像削除処理
	if ($result['id'] == $_SESSION['id']) {
		$dir = 'images/';
		if (file_exists($dir . $result['image_name'])) {
			unlink ($dir . $result['image_name']);
		}
		$sql2 = 'UPDATE users SET image_name = :image_name WHERE id = :id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':image_name', NULL);
		$stmt2->bindValue(':id', $_GET['user_id']);
		$stmt2->execute();
		$message = '画像を削除しました。';
	} else {
		header('Location: display_post.php');
		exit();
	}
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>削除ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $message; ?>
<p><a href="user_info.php?user_id=<?php echo $_GET['user_id']; ?>">マイページへ</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
