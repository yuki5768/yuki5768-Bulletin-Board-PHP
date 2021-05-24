<?php
//セッションチェック
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
}
//未入力確認
if (!empty($_POST['title']) && !empty($_POST['body']) && !empty($_GET['post_id'])) {
	//DB接続
	require_once('connect.php');

	//DBに投稿登録
	$sql = 'INSERT INTO reply(post_id, user_id, title, body, reply_date, deleted_flag) VALUES(:post_id, :user_id, :title, :body, now(), 0)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':post_id', $_GET['post_id']);
	$stmt->bindValue(':user_id', $_GET['user_id']);
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
<?php if (!empty($_GET['post_id'])): ?>
<p><a href="reply.php?post_id=<?php echo $_GET['post_id']; ?>">戻る</a></p>
<?php else: ?>
<p><a href="display_post.php">投稿一覧に戻る</a></p>
<?php endif; ?>
</body>
</html>

