<?php

class ArticleHandler
{
    
    function get(ToroPHP_Request $request)
    {
        $article      = get_article_by_slug($request->getValue('get', 'urlParameter_1'));
        $comments     = get_article_comments($article['id']);
        
        include("views/article.php");
    }
}