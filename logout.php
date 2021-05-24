<?php
//セッションチェック
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	$_SESSION = array();
	setcookie(session_name(), '', time() - 1800, '/');
	session_destroy();
} else {
	header ('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ログアウト</title>
<meta charset="utf-8">
</head>
<body>
<?php if (isset($_SESSION['id']) && isset($_SESSION['name'])): ?>
<h1>ログアウトしました</h1>
<p><a href="login.php">ログインページに戻る</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
<?php else: ?>
<?php header('Location: display_post.php'); ?>
<?php endif; ?>
</body>
</html>
