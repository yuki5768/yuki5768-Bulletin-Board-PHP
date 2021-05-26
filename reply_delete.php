<?php
//セッションチェック
session_start();
if (empty($_SESSION['id']) && empty($_SESSION['name'])) {
	header('Location: display_post.php');
}

//ユーザー確認
if (!empty($_GET['reply_id']) && !empty($_GET['user_id'])) {
	if ($_GET['user_id'] == $_SESSION['id']) {

		//DB接続
		require_once('connect.php');
		$sql1 = 'SELECT * FROM reply WHERE id = :reply_id AND user_id = :user_id';
		$stmt1 = $dbh->prepare($sql1);
		$stmt1->bindValue(':reply_id', $_GET['reply_id']);
		$stmt1->bindValue(':user_id', $_GET['user_id']);
		$stmt1->execute();
		$result = $stmt1->fetch();

		if (!empty($result)) {
			//投稿削除処理
			$sql2 = 'UPDATE reply SET deleted_flag = 1 WHERE id = :id';
			$stmt2 = $dbh->prepare($sql2);
			$stmt2->bindValue(':id', $_GET['reply_id']);
			$stmt2->execute();
			$answer = '削除が完了しました。';
		} else {
			$answer = '削除する返信が見つかりませんでした。';
		}

	} else {
		$answer = '削除する返信が見つかりませんでした。';
	}

} else {
	$answer = '削除する返信が見つかりませんでした。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>削除ページ</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<p><?php echo $answer; ?></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
