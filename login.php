<?php
//セッションチェック
session_start();
if (!empty($_SESSION['id']) && !empty($_SESSION['name'])) {
		header('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ログインページ</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<h1>ログイン情報入力欄</h1>
<form name="login" action="login_check.php" method="POST">
<p>
<label for="mail">メールアドレス:</label>
<input type="text" name="mail">
</p>
<p>
<label for="pass">パスワード:</label>
<input type="password"name="pass">
</p>
<input type="submit" name="button" value="ログイン">
</form>
<p><a href="display_post.php">投稿一覧へ</a></p>
<p><a href="reset.php">パスワードを忘れた方はこちら</a></p>
<p><a href="register.php">新規登録はこちら</a></p>
</div>
</body>
</html>
