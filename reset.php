<?php
//keyチェック
if (!empty($_GET['key'])) {
	$key = $_GET['key'];
	//DB接続&データ取得
	require_once('connect.php');
	$sql = 'SELECT * FROM pass_reset WHERE reset_token = :token';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':token', $key);
	$stmt->execute();
	$result = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>パスワード再設定ページ</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php if (empty($key)): ?>
<h2>登録済みのメールアドレスを入力してください</h2>
<form name="pass_reset" action="mail_check.php" method="POST">
<label>メールアドレス</label>
<p><input type="text" name="mail"></p>
<input type="submit" name="reset" value="送信">
</form>
<?php else: ?>
<h2>新しいパスワードを入力してください</h2>
<form name="reset_pass" action="pass_reset.php?key=<?php echo $key; ?>" method="POST">
<label>新しいパスワード</label>
<p><input type="password" name="pass"></p>
<input type="submit" value="変更">
</form>
<?php endif; ?>
</div>
</body>
</html>
