<?php
//セッションチェック
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	header('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>新規登録ページ</title>
<meta charset="utf-8">
</head>
<body>
<h1>登録情報入力欄</h1>
<form name="register" action="register_check.php" method="POST">
<p>名前:<input type="text" name="name"></p>
<p>メールアドレス:<input type="text" name="mail"></p>
<p>パスワード:<input type="password" name="pass"></p>
<input type="submit" name="button" value="新規登録">
</form>
<p><a href="login.php">ログイン画面へ</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
