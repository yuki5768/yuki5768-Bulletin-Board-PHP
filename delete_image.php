<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) && empty($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

//ユーザー確認
if (!empty($_GET['user_id'])) {
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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php echo $message; ?>
<p><a href="user_info.php?user_id=<?php echo $_GET['user_id']; ?>">マイページへ</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
