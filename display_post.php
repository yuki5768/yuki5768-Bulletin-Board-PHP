<?php
//セッションチェック
session_start();

//ページ数取得
if (!empty($_GET['page'])) {
	$page = ($_GET['page'] - 1) * 3;
} else {
	$page = 0;
}

//DB接続&データ取得
require_once('connect.php');
$sql1 = 'SELECT * FROM users INNER JOIN posts ON posts.user_id = users.id WHERE deleted_flag = 0 ORDER BY posts.id DESC LIMIT 3 OFFSET :page';
$stmt1 = $dbh->prepare($sql1);
$stmt1->bindValue(':page', $page, PDO::PARAM_INT);
$stmt1->execute();
$result = $stmt1->fetchAll();

$sql2 = 'SELECT * FROM posts WHERE deleted_flag = 0';
$stmt2 = $dbh->prepare($sql2);
$stmt2->execute();
$count = $stmt2->rowCount();

//1ページあたりの投稿表示数
define('MAX', '3');
$max_page = ceil($count / MAX);
if (!empty($_GET['page'])) {
	$now = $_GET['page'];
} else {
	$now = 1;
}

//エスケープ処理
function escape($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>投稿一覧</title>
<meta charset="utf-8">
</head>
<body>
<?php if (!empty($_SESSION['name']) && !empty($_SESSION['id'])): ?>
<p><?php echo $_SESSION['name']; ?>さんのアカウントでログイン中</p>
<p><a href="user_info.php?user_id=<?php echo $_SESSION['id']; ?>">マイページへ</a></p>
<p><a href="logout.php">ログアウト</a></p>
<?php else: ?>
<p>ゲストととして閲覧中</p>
<p><a href="login.php">ログイン</a></p>
<p><a href="register.php">新規ユーザー登録へ</a></p>
<?php endif; ?>
<p><a href="new_post.php">新規投稿</a></p>

<!-- 投稿一覧表示 -->
<?php foreach ($result as $post): ?>
<table border="5">
<p>
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿日時</th>
<th>操作一覧</th>
</tr>
<tr>
<td><?php echo escape($post['id']); ?></td>
<td><a href="user_info.php?user_id=<?php echo $post['user_id']; ?>"><?php echo escape($post['name']); ?></a></td>
<td><?php echo escape($post['title']); ?></td>
<td><?php echo escape($post['body']); ?></td>
<td><?php echo date('Y年n月j日G:i', strtotime(escape($post['post_date']))); ?></td>
<?php if (!empty($_SESSION['id']) && !empty($_SESSION['name'])): ?>
<?php if ($post['user_id'] == $_SESSION['id']): ?>
<td>
<p><a href="edit.php?post_id=<?php echo escape($post['id']); ?>">編集</a></p>
<p><a href="delete.php?post_id=<?php echo escape($post['id']); ?>">削除</a></p>
<p><a href="reply.php?post_id=<?php echo escape($post['id']); ?>&user_id=<?php echo $_SESSION['id']; ?>">返信を書く</a></p>
<p><a href="show_reply.php?post_id=<?php echo escape($post['id']); ?>">返信を見る</a></p>
</td>
<?php else: ?>
<td>
<p><a href="reply.php?post_id=<?php echo escape($post['id']); ?>&user_id=<?php echo $_SESSION['id']; ?>">返信を書く</a></p>
<p><a href="show_reply.php?post_id=<?php echo escape($post['id']); ?>">返信を見る</a></p>
</td>
<?php endif; ?>
<?php else: ?>
<td><p>この投稿に対して行える操作はありません。</p></td>
<?php endif; ?>
</tr>
</p>
</table>
<?php endforeach; ?>

<!-- ページング用リンク -->
<?php if ($now > 1): ?>
<a href="display_post.php?page=<?php echo $now - 1; ?>">前へ</a>
<?php else: ?>
<?php echo '前へ'; ?>
<?php endif; ?>
<?php echo $now . '/' . $max_page; ?>
<?php if ($now < $max_page):?>
<a href="display_post.php?page=<?php echo $now + 1; ?>">次へ</a>
<?php else: ?>
<?php echo '次へ'; ?>
<?php endif; ?>

</body>
</html>
