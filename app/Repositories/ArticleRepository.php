<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getAllArticles()
    {
        return $this->queryInstance()->all();
    }

    public function getArticleById($id)
    {
        return $this->queryInstance()->findOrFail($id);
    }

    public function createArticle(array $data)
    {
        return $this->queryInstance()->create($data);
    }

    public function updateArticle($id, array $data)
    {
        $article = $this->queryInstance()->findOrFail($id);
        $article->update($data);
        return $article;
    }

    public function deleteArticle($id)
    {
        $article = $this->queryInstance()->findOrFail($id);
        $article->delete();
    }

    private function queryInstance()
    {
        return new Article();
    }
}
