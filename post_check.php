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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php echo $answer; ?>
<p><a href="display_post.php">投稿一覧へ<a/></p>
</div>
</body>
</html>
