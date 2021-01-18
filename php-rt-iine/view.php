<?php
session_start();
require_once('function/dbconnect.php');
require_once('function/htmlspecialchars.php');

if (empty($_REQUEST['id'])) {
    header('Location: index.php');
    exit();
}

// 投稿を取得する
$posts = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
$posts->execute([$_REQUEST['id']]);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/250c1a3838.js" crossorigin="anonymous"></script>
	<title>ひとこと掲示板</title>

	<link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="msg">
        <h1>ひとこと掲示板</h1>
        <div class="msg_wrapper">
            <?php
            if ($post = $posts->fetch()):
            ?>
            <div class="msg_container">
                <img src="member_picture/<?php echo h($post['picture'])?>" width="48" height="48" alt="<?php echo h($post['name']); ?>" />
                <article class="user">
                <p><span class="name"><?php echo h($post['name']); ?></span>
                </article>
                <article class="day">
                <p class="created"><?php echo h($post['created']); ?></p>
                </article>
            </div>
                <article class="post">
                <?php echo h($post['message']); ?></p>
                </article>
                <?php
                else:
                ?>
                <p>その投稿は削除されたか、URLが間違えています</p>
                <?php
                endif;
                ?>
        </div>
        <p class="paging"><a href="index.php"><i class="far fa-caret-square-left"></i> Back</a></p>
    </div>
</body>
</html>
