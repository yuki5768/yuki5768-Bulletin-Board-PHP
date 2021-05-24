<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) || empty($_SESSION['name'])) {
	header('Location: display_post.php');
}

//DB接続
if (!empty($_GET['reply_id']) && !empty($_GET['user_id'])) {
	if ($_GET['user_id'] == $_SESSION['id']) {
		require_once('connect.php');
		//ユーザーIDチェック
		$sql = 'SELECT * FROM reply WHERE id = :reply_id AND user_id = :user_id';
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':reply_id', $_GET['reply_id']);
		$stmt->bindValue(':user_id', $_GET['user_id']);
		$stmt->execute();
		$result = $stmt->fetch();
	} else {
		header('Location: display_post.php');
	}
} else {
	header('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>編集ページ</title>
<meta charset="utf-8">
</head>
<body>
<form method="POST" action="reply_edit_check.php?reply_id=<?php echo $_GET['reply_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>">
<p>
<h2>タイトル</h2>
<input type="text" name="title" value="<?php echo $result['title']; ?>">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"><?php echo $result['body']; ?></textarea>
</p>
<p><input type="submit" name="更新"></p>
</form>
</body>
</html>