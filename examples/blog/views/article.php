<h1>Blog</h1>
<?php include("_article.php"); ?>

<h3>Comments (<?= count($comments); ?>)</h3>
<?php
    foreach ($comments as $comment) {
        include("_comment.php");
    }
?>

<h4>Add Comment</h4>
<form method="post" action="/examples/blog/article/<?= $article['slug']; ?>/comment">
    <strong>Name:</strong><br/>
    <input type="text" name="name" /><br/>
    <strong>Message:</strong><br/>
    <textarea name="body"></textarea><br/>
    <input type="submit" />
</form>