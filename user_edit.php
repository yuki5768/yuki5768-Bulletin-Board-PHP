<?php
//セッションチェック
session_start();
if (isset($_GET['user_id'])) {
	//DB接続
	require_once('connect.php');
	//ユーザー情報チェック
	$sql = 'SELECT * FROM users WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $_GET['user_id']);
	$stmt->execute();
	$result = $stmt->fetch();
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ユーザー情報編集</title>
<meta charset="utf-8">
</head>
<body>
<h3>更新したい項目を入力してください。</h3>
<?php if ($_GET['user_id'] == $_SESSION['id']): ?>
<form method="post" action="upload.php?user_id=<?php echo $_SESSION['id']; ?>" enctype="multipart/form-data">
<p><label>画像ファイルの添付</label></p>
<p><input type="file" name="image"></p>
<p><label>一言コメント</label></p>
<p><input type="text" name="quick_comment" value="<?php echo $result['quick_comment']; ?>"></p>
<input type="submit" name="upload" value="更新">
<p><a href="user_info.php?user_id=<?php echo $_GET['user_id']; ?>">マイページへ戻る</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
<p><a href="logout.php">ログアウト</a></p>
</form>
<?php else: ?>
<?php header('Location: display_post.php'); ?>
<?php exit(); ?>
<?php endif; ?>
</body>
</html>
