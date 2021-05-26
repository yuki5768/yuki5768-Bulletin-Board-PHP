<?php
//セッションチェック
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>新規投稿ページ</title>
<meta charset="utf-8">
</head>
<body>
<div style=" color: white; background: #f98289; padding: 20px; border: 2px dashed rgba(255 , 255 , 255 , 0.5);-moz-border-radius: 6px; -moz-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); -webkit-border-radius: 6px; -webkit-box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); border-radius: 6px; box-shadow: 0 0 0 5px #f98289 , 0 2px 3px 5px rgba(0 , 0 , 0 , 0.5); font-size: 100%; ">
<h1>新規投稿ページ</h1>
<?php if (!empty($_SESSION['id']) && !empty($_SESSION['name'])): ?>
<form name="new_post" action="post_check.php" method="POST">
<p>
<h2>タイトル</h2>
<input type="text" name="title">
</p>
<p>
<h2>本文</h2>
<textarea name="body" rows="5" cols="50"></textarea>
</p>
<input type="submit" name="button" value="投稿">
<p><a href="user_info.php?user_id=<?php echo $_SESSION['id']; ?>">マイページへ</a></p>
<p><a href="display_post.php">投稿一覧へ</a></p>
<p><a href="logout.php">ログアウト</a></p>
</form>
<?php else: ?>
<?php
header('Location: register.php');
exit;
?>
<?php endif; ?>
</div>
</body>
</html>
