<?php
//セッションチェック
session_start();
if (!empty($_GET['user_id']) && !empty($_POST['upload'])) {
	//DB接続
	require_once('connect.php');
	//ユーザー取得
	$sql1 = 'SELECT * FROM users WHERE id = :id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':id', $_GET['user_id']);
	$stmt1->execute();
	$result = $stmt1->fetch();
	if ($result['id'] == $_SESSION['id']) {
		//画像ファイルチェック
		if (!empty($_FILES['image']['name']) && !(exif_imagetype($_FILES['image']['tmp_name']))) {
			$message = '画像ではないファイルが選択されています。';
			//未入力チェック
		} elseif (empty($_FILES['image']['name']) && empty($_POST['quick_comment'])) {
			$message = '編集する項目が何も入力されていません。';
		} else {
			//ユーザー情報アップデート処理
			$sql2 = 'UPDATE users SET image_name = :image_name, quick_comment = :quick_comment WHERE id = :id';
			$stmt2 = $dbh->prepare($sql2);
			//画像ファイル存在チェック
			if (empty($_FILES['image']['name'])) {
				$image_name = $result['image_name'];
			} else {
				//画像タイプ識別
				$image_type = exif_imagetype($_FILES['image']['tmp_name']);
				switch ($image_type) {
				case IMAGETYPE_GIF:
					$type = '.gif';
					break;
				case IMAGETYPE_JPEG:
					$type = '.jpg';
					break;
				case IMAGETYPE_PNG:
					$type = '.png';
					break;
				}
				//ディレクトリ内の画像ファイル削除
				$dir = './images/';
				if (!empty($result['image_name'])) {
					unlink($dir . $result['image_name']);
				}
				//新しい画像のアップロード処理
				$image = uniqid(mt_rand(), true);
				move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image . $type);
				$image_name = $image . $type;
			}

			//一言コメント入力チェック
			if (empty($_POST['quick_comment'])) {
				$quick_comment = $result['quick_comment'];
			} else {
				$quick_comment = $_POST['quick_comment'];
			}

			//ユーザー情報更新処理
			$stmt2->bindValue('image_name', $image_name);
			$stmt2->bindValue('quick_comment', $quick_comment);
			$stmt2->bindValue(':id', $_GET['user_id']);
			$stmt2->execute();
			$message = 'アップロードが完了しました。';
		}
	} else {
		header('Location: display_post.php');
		exit();
	}
} else {
	header('Location: display_post.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>ユーザー情報アップロード</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $message; ?>
<p><a href="user_info.php?user_id=<?php echo $_GET['user_id']; ?>">マイページへ戻る</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>
