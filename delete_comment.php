<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) && empty($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

//ユーザー確認＆DB接続
if (!empty($_GET['user_id'])) {
	//DB接続
	require_once('connect.php');
	$sql1 = 'SELECT * FROM users WHERE id = :id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':id', $_GET['user_id']);
	$stmt1->execute();
	$result = $stmt1->fetch();

	//一言コメント削除処理
	if ($result['id'] == $_SESSION['id']) {
		$sql2 = 'UPDATE users SET quick_comment = :quick_comment WHERE id = :id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':quick_comment', NULL);
		$stmt2->bindValue(':id', $_GET['user_id']);
		$stmt2->execute();
		$message = '一言コメントを削除しました。';
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

