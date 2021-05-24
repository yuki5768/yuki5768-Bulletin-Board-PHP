<?php
//セッションチェック
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
}
//未入力確認
if (!empty($_POST['title']) && !empty($_POST['body'])) {
	require_once('connect.php');
	//DBに投稿登録
	$sql = 'INSERT INTO posts(user_id, post_date, title, body, deleted_flag) VALUES(:user_id, now(), :title, :body, 0)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':user_id', $_SESSION['id']);
	$stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':body', $_POST['body']);
	$stmt->execute();
	header ('Location: display_post.php');
} else {
	$answer = '入力されていない項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>投稿確認</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $answer; ?>
<p><a href="display_post.php">投稿一覧へ<a/></p>
</body>
</html>
