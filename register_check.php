<?php
//セッションチェック
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	header('Location: display_post.php');
	exit();
}

//未入力確認
if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])) {
	//メールアドレスチェック
	if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_POST['mail'])) {
		//パスワードチェック
		if (preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])) {
			//DB接続
			require_once('connect.php');
			//メールアドレスの被りチェック
			$sql1 = 'SELECT * FROM users WHERE mail = :mail';
			$stmt1 = $dbh->prepare($sql1);
			$stmt1->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
			$stmt1->execute();
			$result = $stmt1->fetch();
			if ($result) {
				$answer = '同じメールアドレスは登録できません。';
			} else {
				//ユーザー登録
				$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
				$sql2 = 'INSERT INTO users(name, mail, pass) VALUES (:name, :mail, :pass)';
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->bindParam(':name', $_POST['name']);
				$stmt2->bindParam(':mail', $_POST['mail']);
				$stmt2->bindParam(':pass', $pass);
				$stmt2->execute();
				$answer = '登録が完了しました。';
			}
		} else {
			$answer = 'パスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上100文字以下のものにしてください';
		}
	} else {
		$answer = 'メールアドレスの形式が正しくありません。';
	}
} else {
	$answer = '入力されていない項目があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>登録結果</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])): ?>
<?php if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_POST['mail'])): ?>
<?php if (preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])): ?>
<?php if ($result): ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="login.php">ログインページへ</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
<?php else: ?>
<?php echo $answer; ?>
<p><a href="register.php">戻る</a></p>
<?php endif; ?>
</div>
</body>
</html>
