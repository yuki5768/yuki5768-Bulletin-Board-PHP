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
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<h1>登録情報入力欄</h1>
<form name="register" action="register_check.php" method="POST">
<p>名前:<input type="text" name="name"></p>
<p>メールアドレス:<input type="text" name="mail"></p>
<p>パスワード:<input type="password" name="pass"></p>
<input type="submit" name="button" value="新規登録">
</form>
<p><a href="login.php">ログイン画面へ</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
