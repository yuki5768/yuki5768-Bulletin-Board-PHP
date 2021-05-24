<?php
//セッションチェック
session_start();
if (!empty($_GET['user_id']) && !empty($_SESSION['id'])) {
	//DB接続
	require_once('connect.php');
	$user_id = $_GET['user_id'];

	//ユーザー情報取得処理
	$sql1 = 'SELECT * FROM users WHERE id = :user_id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':user_id', $user_id);
	$stmt1->execute();
	$user = $stmt1->fetch();

	$sql2 = 'SELECT * FROM reply WHERE user_id = :user_id';
	$stmt2 = $dbh->prepare($sql2);
	$stmt2->bindValue(':user_id', $user_id);
	$stmt2->execute();
	$result = $stmt2->fetchAll();

} else {
	header('Location: display_post.php');
	exit();
}
function escape($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>マイページ</title>
<meta charset="utf-8">
</head>
<body>
<h1>マイページ</h1>
<h2>プロフィール</h2>
<?php if (!empty($_SESSION['id'])): ?>
<?php if ($user['id'] == $_SESSION['id']): ?>
<p><a href="user_edit.php?user_id=<?php echo $_SESSION['id']; ?>">プロフィール編集</a></p>
<p><a href="logout.php">ログアウト</a></p>
<?php endif; ?>
<?php endif; ?>

<!-- ユーザー情報表示 -->
<table border="1">
<tr>
<th>ユーザー名</th>
<th>ユーザー画像</th>
<th>メールアドレス</th>
<th>一言コメント</th>
<th>操作一覧</th>
</tr>

<tr>
<!-- ユーザー名 -->
<td><?php echo escape($user['name']); ?></td>

<!-- プロフィール画像 -->
<?php if (!empty($user['image_name'])): ?>
<td>
<img src="images/<?php echo $user['image_name']; ?>" width="300" height="300">
</td>
<?php else: ?>
<td><p>未登録</p></td>
<?php endif; ?>

<!-- メールアドレス -->
<td><?php echo escape($user['mail']); ?></td>

<!-- 一言コメント -->
<?php if (!empty($user['quick_comment'])): ?>
<td>
<?php echo escape($user['quick_comment']); ?>
</td>
<?php else: ?>
<td><p>未登録</p></td>
<?php endif; ?>

<!-- 操作一覧 -->
<td>
<?php if (!empty($user['image_name']) && $user['id'] == $_SESSION['id']): ?>
<p><a href="delete_image.php?user_id=<?php echo $_SESSION['id']; ?>">画像削除</a></p>
<?php endif; ?>
<?php if (!empty($user['quick_comment']) && $user['id'] == $_SESSION['id']): ?>
<p><a href="delete_comment.php?user_id=<?php echo $_SESSION['id']; ?>">一言コメント削除</a></p>
<?php endif; ?>
<?php if (empty($user['image_name']) && empty($user['quick_comment'])): ?>
<p>実行できる操作はありません。</p>
<?php endif; ?>
</td>
</tr>
</table>

<!-- 過去の返信履歴 -->
<h2>返信履歴</h2>
<?php if (!empty($result)): ?>
<p>
<?php foreach($result as $reply): ?>
<table border="1">
<tr>
<th>返信した投稿ID</th>
<th>返信タイトル</th>
<th>返信内容</th>
<th>返信日時</th>
</tr>
<tr>
<td><a href="show_reply.php?post_id=<?php echo escape($reply['post_id']); ?>"><?php echo escape($reply['post_id']); ?></a></td>
<td><?php echo escape($reply['title']); ?></td>
<td><?php echo escape($reply['body']); ?></td>
<td><?php echo date('Y年n月j日G:i', strtotime(escape($reply['reply_date']))); ?></td>
</tr>
</table>
</p>
<?php endforeach; ?>
<?php else: ?>
<p>返信履歴がありません。</p>
<?php endif; ?>
<p><a href="display_post.php">投稿一覧へ</a></p>
</body>
</html>