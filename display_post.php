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
<div style=" color: black; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; text-align:center;">
<h1>Web掲示板</h1>
<?php if (!empty($_SESSION['name']) && !empty($_SESSION['id'])): ?>
<p><span style="color:white"><?php echo $_SESSION['name']; ?></span>さんのアカウントでログイン中</p>
<p><a href="user_info.php?user_id=<?php echo $_SESSION['id']; ?>">・マイページへ</a></p>
<p><a href="logout.php">・ログアウト</a></p>
<?php else: ?>
<p>ゲストととして閲覧中</p>
<p><a href="login.php">・ログイン</a></p>
<p><a href="register.php">・新規ユーザー登録へ</a></p>
<?php endif; ?>
<p><a href="new_post.php">・新規投稿</a></p>

<!-- ページング用リンク(上) -->
<div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333;">
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

<!-- 投稿一覧表示 -->
<?php foreach ($result as $post): ?>
<div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333; border-radius: 10px; background-color: #009999; color: #ffffff; text-align:left">
<p>[投稿ID：<?php echo escape($post['id']); ?>]</p>
<p>[投稿者：<?php echo escape($post['name']); ?>さん] / [投稿日時：<?php echo date('Y/n/j/G:i', strtotime(escape($post['post_date']))); ?>]</p>
<p>[タイトル]</p>
<p><?php echo escape($post['title']); ?></p>
<p>[本文]</p>
<p><?php echo escape($post['body']); ?></p>
<p>[操作一覧]</p>
<?php if (!empty($_SESSION['id']) && !empty($_SESSION['name'])): ?>
<?php if ($post['user_id'] == $_SESSION['id']): ?>
<p><a href="edit.php?post_id=<?php echo escape($post['id']); ?>">編集</a></p>
<p><a href="delete.php?post_id=<?php echo escape($post['id']); ?>">削除</a></p>
<p><a href="reply.php?post_id=<?php echo escape($post['id']); ?>&user_id=<?php echo $_SESSION['id']; ?>">返信を書く</a></p>
<p><a href="show_reply.php?post_id=<?php echo escape($post['id']); ?>">返信を見る</a></p>
<?php else: ?>
<p><a href="reply.php?post_id=<?php echo escape($post['id']); ?>&user_id=<?php echo $_SESSION['id']; ?>">返信を書く</a></p>
<p><a href="show_reply.php?post_id=<?php echo escape($post['id']); ?>">返信を見る</a></p>
<?php endif; ?>
<?php else: ?>
<p>この投稿に対して行える操作はありません。</p>
<?php endif; ?>
</div>
<?php endforeach; ?>

<!-- ページング用リンク(下) -->
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
</div>
</div>

</body>
</html>
