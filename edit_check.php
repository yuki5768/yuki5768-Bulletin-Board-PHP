<?php
//セッションチェック
session_start();
if (isset($SESSION['id']) && isset($_SESSION['name'])) {
	header('Location: display_post.php');
}

//未入力確認
if (isset($_GET['post_id']) && isset($_POST['title']) && isset($_POST['body'])) {
	$post_id = $_GET['post_id'];
	$post_title = $_POST['title'];
	$post_body = $_POST['body'];

	//DB接続
	require_once('connect.php');

	//投稿取得
	$sql = 'SELECT * FROM posts WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $post_id);
	$stmt->execute();
	$result = $stmt->fetch();

	//本人確認＆投稿更新処理
	if ($result['user_id'] == $_SESSION['id']) {
		$sql2 = 'UPDATE posts SET title = :title, body = :body WHERE id = :id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':title', $post_title);
		$stmt2->bindValue(':body', $post_body);
		$stmt2->bindValue(':id', $post_id);
		$stmt2->execute();
		$message = '編集が完了しました。';
	} else {
		$message = '管理者が異なっています。';
	}
} else {
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

