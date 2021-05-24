<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) || empty($_SESSION['name'])) {
	header('Location: display_post.php');
}

//未入力確認
if (!empty($_GET['reply_id']) && !empty($_GET['user_id']) && !empty($_POST['title']) && !empty($_POST['body'])) {
	//本人確認
	if ($_GET['user_id'] == $_SESSION['id']) {
		$reply_id = $_GET['reply_id'];
		$user_id = $_GET['user_id'];
		$reply_title = $_POST['title'];
		$reply_body = $_POST['body'];

		//DB接続
		require_once('connect.php');

		//投稿取得
		$sql1 = 'SELECT * FROM reply WHERE id = :id AND user_id = :user_id';
		$stmt1 = $dbh->prepare($sql1);
		$stmt1->bindValue(':id', $reply_id);
		$stmt1->bindValue(':user_id', $user_id);
		$stmt1->execute();
		$result = $stmt1->fetch();

		//更新処理
		$sql2 = 'UPDATE reply SET title = :title, body = :body WHERE id = :id AND user_id = :user_id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':title', $reply_title);
		$stmt2->bindValue(':body', $reply_body);
		$stmt2->bindValue(':id', $reply_id);
		$stmt2->bindValue(':user_id', $user_id);
		$stmt2->execute();

		$message = '処理が完了しました。';
	} else {
		$message = '管理者が異なっています。';
	}
} else {
	echo $_GET['reply_id'] . $_GET['user_id'];
	$message = '未入力の項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>更新ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $message; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
