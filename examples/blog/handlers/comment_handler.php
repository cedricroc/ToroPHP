<?php

class CommentHandler
{
    function post(ToroPHP_Request $request)
    {
        $slug  = $request->getValue('get', 'urlParameter_1');
        
        $article = get_article_by_slug($slug);
        
        
        
        $datas = $request->getDatas('post');
        
        if (isset($datas['name']) && isset($datas['body']) && 
            strlen(trim($datas['name'])) > 0 && strlen(trim($datas['body'])) > 0) {
            save_comment($article['id'], trim($datas['name']), trim($datas['body']));
        }
        
        header("Location: /examples/blog/article/$slug");
    }
}