<?php
//セッションチェック
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])) {
	header('Location: display_post.php');
}

//ユーザー確認
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];

	//DB接続
	require_once('connect.php');
	$sql1 = 'SELECT * FROM posts WHERE id = :id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':id', $post_id);
	$stmt1->execute();
	$result = $stmt1->fetch();

	//投稿削除処理
	if ($result['user_id'] == $_SESSION['id']) {
		$sql2 = 'UPDATE posts SET deleted_flag = 1 WHERE id = :id';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':id', $post_id);
		$stmt2->execute();
		$answer = '処理が完了しました。';
	} else {
		$answer = 'ユーザーが異なっています。';
	}
} else {
	header('Location: display_post.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>削除ページ</title>
<meta charset="utf-8">
</head>
<body>
<?php if ($result['user_id'] == $_SESSION['id']): ?>
<?php echo $answer; ?>
<?php else: ?>
<?php echo $answer; ?>
<?php endif; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
