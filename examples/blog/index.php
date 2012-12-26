<?php


require('../../bootstrap.php');

require('handlers/article_handler.php');
require('handlers/articles_handler.php');
require('handlers/comment_handler.php');
require('lib/markdown.php');
require('lib/mysql.php');
require('lib/queries.php');

ToroPHP_Hook::add('404', function() {
    echo 'Page not found';
});

$routes = array(
    '/'                         => 'ArticlesHandler',
    '/article/:alpha'           => 'ArticleHandler',
    '/article/:alpha/comment'   => 'CommentHandler'
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();