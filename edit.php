<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) && empty($_SESSION['name'])) {
	header('Location: display_post.php');
}

if (!empty($_GET['post_id'])) {
	//DB接続&データ取得
	require_once('connect.php');
	$post_id = $_GET['post_id'];
	$sql = 'SELECT * FROM posts WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $post_id);
	$stmt->execute();
	$result = $stmt->fetch();
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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php if (!empty($result)): ?>
<?php if ($result['user_id'] == $_SESSION['id']): ?>
<form method="POST" action="edit_check.php?post_id=<?php echo $post_id; ?>">
<p>
<h2>タイトル</h2>
<input type="text" name="title" value="<?php echo $result['title']; ?>">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"><?php echo $result['body']; ?></textarea>
</p>
<p><input type="submit" value="編集する"></p>
</form>
<p><a href="display_post.php">投稿一覧へ</a></p>
<p><a href="user_info.php?user_id=<?php echo $_SESSION['id']; ?>">マイページへ</a></p>
<p><a href="logout.php">ログアウト</a></p>
<?php else: ?>
<?php header('Location: display_post.php'); ?>
<?php endif; ?>
<?php endif; ?>
</div>
</body>
</html>

