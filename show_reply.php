<?php
session_start();

if (!empty($_GET['post_id'])) {
	//DB接続
	require_once('connect.php');

	//投稿取得
	$sql1 = 'SELECT * FROM users INNER JOIN posts ON posts.user_id = users.id WHERE deleted_flag = 0 AND posts.id = :post_id';
	$stmt1 = $dbh->prepare($sql1);
	$stmt1->bindValue(':post_id', $_GET['post_id']);
	$stmt1->execute();
	$result1 = $stmt1->fetchAll();

	//返信取得
	$sql2 = 'SELECT * FROM users INNER JOIN reply ON reply.user_id = users.id WHERE post_id = :post_id AND deleted_flag = 0';
	$stmt2 = $dbh->prepare($sql2);
	$stmt2->bindValue(':post_id', $_GET['post_id']);
	$stmt2->execute();
	$result2 = $stmt2->fetchAll();

	function escape($s) {
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}
} else {
	header('Location: display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>返信一覧</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">

<!-- 投稿表示 -->
<h2>投稿</h2>
<?php if (!empty($result1)): ?>
<?php foreach ($result1 as $post): ?>
<table border="5">
<p>
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿日時</th>
</tr>
<tr>
<td><?php echo escape($post['id']); ?></td>
<td>
<a href="user_info.php?user_id=<?php echo $post['user_id']; ?>"><?php echo escape($post['name']); ?></a>
</td>
<td><?php echo escape($post['title']); ?></td>
<td><?php echo escape($post['body']); ?></td>
<td><?php echo date('Y年n月j日G:i', strtotime(escape($post['post_date']))); ?></td>
</tr>
</p>
</table>
<?php endforeach; ?>
<?php else: ?>
<?php
header('Location: display.php');
exit();
?>
<?php endif; ?>

<!-- 返信一覧表示 -->
<h2>返信</h2>
<?php if (!empty($result2)): ?>
<?php foreach ($result2 as $reply): ?>
<table border="1">
<p>
<tr>
<th>返信ID</th>
<th>返信者名</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿日時</th>
<th>操作一覧</th>
</tr>
<tr>
<td><?php echo escape($reply['id']); ?></td>
<td><?php echo escape($reply['name']); ?></td>
<td>
<?php echo escape ($reply['title']); ?>
<td><?php echo escape($reply['body']); ?></td>
<td><?php echo date('Y年n月j日G:i', strtotime(escape($reply['reply_date']))); ?></td>
<?php if ($reply['user_id'] == $_SESSION['id']): ?>
<td>
<p><a href="reply_edit.php?reply_id=<?php echo $reply['id']; ?>&user_id=<?php echo $reply['user_id']; ?>">編集</a></p>
<p><a href="reply_delete.php?reply_id=<?php echo $reply['id']; ?>&user_id=<?php echo $reply['user_id']; ?>">削除</a></p>
</td>
<?php else: ?>
<td><p>この返信に対して行える操作はありません。</p></td>
<?php endif; ?>
</tr>
</p>
</table>
<?php endforeach; ?>
<?php else: ?>
<p>この投稿に対する返信はまだありません。</p>
<?php endif; ?>

<!-- 他ページへのリンク -->
<?php if (!empty($_SESSION['name']) && !empty($_SESSION['id'])): ?>
<p><a href="user_info.php?user_id=<?php echo $_SESSION['id']; ?>">マイページへ</a></p>
<p><a href="logout.php">ログアウト</a></p>
<?php else: ?>
<p><a href="login.php">ログイン</a></p>
<p><a href="register.php">新規ユーザー登録へ</a></p>
<?php endif; ?>
<p><a href="new_post.php">新規投稿</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
</div>
</body>
</html>
