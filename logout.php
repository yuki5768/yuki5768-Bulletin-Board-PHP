<?php
//セッションチェック
session_start();
if (!empty($_SESSION['id']) && !empty($_SESSION['name'])) {
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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<h1>ログアウトしました</h1>
<p><a href="login.php">ログインページに戻る</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
