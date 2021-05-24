<?php
//keyチェック
if (isset($_GET['key'])) {
	$key = $_GET['key'];
	//DB接続
	require_once('connect.php');
	$sql1 = 'SELECT * FROM pass_reset WHERE reset_token = :reset_token';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':reset_token', $key);
	$stmt1->execute();
	$result1 = $stmt1->fetch();
	//keyチェック＆タイムアウトかどうかの確認
	if ($result1['reset_token'] == $key && date('Y-m-d H:i:s', strtotime('-30 minute')) <= $result1['reset_date']) {
		//パスワードチェック
		if (!empty($_POST['pass']) && preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])) {
			//パスワード更新
			$pass = $_POST['pass'];
			$sql2 = 'UPDATE users SET pass = :pass WHERE id = :id';
			$stmt2 = $dbh->prepare($sql2);
			$stmt2->bindValue(':pass', $pass);
			$stmt2->bindValue(':id', $result1['user_id']);
			$stmt2->execute();

			//Dbのパスワードリセット情報削除
			$sql3 = 'DELETE FROM pass_reset WHERE reset_date <= :reset_date OR user_id = :user_id';
			$stmt3 = $dbh->prepare($sql3);
			$stmt3->bindValue(':reset_date', date('Y-m-d H:i:s', strtotime('-30 minute')));
			$stmt3->bindValue(':user_id', $result1['user_id']);
			$stmt3->execute();
			$message = 'パスワードが更新されました。';
		} else {
			$error1 = 'パスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上100文字以下のものにしてください';
		}
	} else {
		$error2 = '不正なアクセスです。再度お試しください。';
	}
} else {
	$error2 = '不正なアクセスです。再度お試しください。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>パスワード再設定</title>
<meta charset="utf-8">
</head>
<body>
<?php if (!empty($message) || !empty($error2)): ?>
<?php if (!empty($message)): ?>
<?php echo $message; ?>
<?php else: ?>
<?php echo $error2; ?>
<?php endif; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
<p><a href="login.php">ログインページへ</a></p>
<?php else: ?>
<?php echo $error1; ?>
<p><a href="reset.php?key=<?php echo $key; ?>">戻る</a></p>
<?php endif; ?>
</body>
</html>

