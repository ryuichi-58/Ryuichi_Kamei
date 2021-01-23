<?php
//いいねしたコメントの投稿者を調べる
if(isset($_POST['post_id'])) {
    $contributor = $db->prepare('SELECT member_id FROM posts WHERE id=?');
    $contributor->execute([$_POST['post_id']]);
    $like_post = $contributor->fetch();

    //いいねした人と投稿者が同じでないか確認
    if($_SESSION['id'] != $like_posts['member_id']) {
        //過去にいいねしていないか確認
        $pressed_like_button = $db->prepare('SELECT COUNT(*) AS cnt FROM likes WHERE post_id=? AND member_id=?');
        $pressed_like_button->execute([
            $_POST['post_id'],
            $_SESSION['id']
        ]);
        $like_cnt = $pressed_like_button->fetch();

        //いいねの登録と削除
        if($like_cnt['cnt'] < 1) {
            $pressing_like = $db->prepare('INSERT INTO likes SET post_id=?, member_id=?');
            $pressing_like->execute([
                $_POST['post_id'],
                $_SESSION['id']
            ]);
        } else {
            $cancel_like = $db->prepare('DELETE FROM likes WHERE post_id=?, member_id=?');
            $cancel_like->execute([
                $_POST['post_id'],
                $_SESSION['id']
            ]);
            header("Location: index.php");
            exit();
        }
    }
}
?>
