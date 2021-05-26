<?php
session_start();
if (!empty($_GET['post_id']) && !empty($_GET['user_id'])) {
	$post_id = $_GET['post_id'];
} else {
	header('Location:display_post.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<?php if (isset($_SESSION['id']) && isset($_SESSION['name'])): ?>
<title>返信内容を書く</title>
<meta charset="utf-8">
</head>
<body>
<h1>返信内容を書く</h1>
<form name="new_reply" action="reply_check.php?post_id=<?php echo $post_id; ?>&user_id=<?php echo $_GET['user_id']; ?>" method="POST">
<p>
<h2>タイトル</h2>
<input type="text" name="title">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"></textarea>
</p>
<input type="submit" name="button" value="返信">
<p><a href="display_post.php">投稿一覧へ</a></p>
</form>
<?php else: ?>
<p>返信を書くにはログインもしくは会員登録してください。</p>
<a href="register.php">会員登録はこちら</p>
<a href="login.php">ログインの方はこちら</p>
<?php endif; ?>
</div>
</body>
</html>
