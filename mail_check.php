<?php
//未入力確認
if (!empty($_POST['mail'])) {
	//DB接続&データ取得
	require_once('connect.php');
	$sql1 = 'SELECT * FROM users WHERE mail = :mail';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':mail', $_POST['mail']);
	$stmt1->execute();
	$result = $stmt1->fetch();

	//メールアドレスチェック
	if (!empty($result) && $result['mail'] == $_POST['mail']) {
		//パスワード再設定用メール
		$token = rand(0, 100) . uniqid();
		$url = $_SERVER['HTTP_REFERER'] . "?key=" . $token;
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = $_POST['mail'];
		$subject = 'パスワード再設定フォーム';
		$message = 'パスワードを再設定するには、以下のアドレスを開いてください。/このURLの有効期限は30分間です。/';
		$message .= $url . "\n\n";
		$headers = 'From: yuuki-v9f379978@i.softbank.jp' . "\r\n";
		mb_send_mail($to, $subject, $message, $headers, '-f' . 'xxxxx@xx.jp');
		$sql2 = 'INSERT INTO pass_reset(user_id, reset_date, reset_token) VALUES (:user_id, now(), :reset_token)';
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->bindValue(':user_id', $result['id']);
		$stmt2->bindValue(':reset_token', $token);
		$stmt2->execute();
	}
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>確認メール送信</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php echo '再発行用URLを送信しました。'; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
