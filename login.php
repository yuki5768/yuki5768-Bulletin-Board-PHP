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
<title>ログインページ</title>
<meta charset="utf-8">
</head>
<body>
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
</body>
</html>
