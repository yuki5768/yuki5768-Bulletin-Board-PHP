<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) && empty($_SESSION['name'])) {
	header('Location: display_post.php');
}
//未入力確認
if (!empty($_POST['title']) && !empty($_POST['body']) && !empty($_GET['post_id'])) {
	//DB接続&データ登録
	require_once('connect.php');
	$sql = 'INSERT INTO reply(post_id, user_id, title, body, reply_date, deleted_flag) VALUES(:post_id, :user_id, :title, :body, now(), 0)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':post_id', $_GET['post_id']);
	$stmt->bindValue(':user_id', $_GET['user_id']);
	$stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':body', $_POST['body']);
	$stmt->execute();
	$answer = '返信が完了しました。';
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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php echo $answer; ?>
<p><a href="reply.php?post_id=<?php echo $_GET['post_id']; ?>">戻る</a></p>
</div>
</body>
</html>

