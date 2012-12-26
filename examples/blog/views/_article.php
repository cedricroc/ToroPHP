<h2><a href="/examples/blog/article/<?= $article['slug']; ?>"><?= $article['title']; ?></a></h2>
<div><?= Markdown($article['body']); ?></div>
<hr />