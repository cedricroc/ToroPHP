<?php

class ArticlesHandler
{
    function get(ToroPHP_Request $request)
    {
        $articles = get_articles();
        
        include("views/articles.php");
    }
}