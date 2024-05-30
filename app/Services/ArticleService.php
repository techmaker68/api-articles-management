<?php


namespace App\Services;

use App\Repositories\ArticleRepositoryInterface;

class ArticleService
{
    protected $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllArticles()
    {
        return $this->articleRepository->getAllArticles();
    }

    public function getArticleById($id)
    {
        return $this->articleRepository->getArticleById($id);
    }

    public function createArticle(array $data)
    {
        return $this->articleRepository->createArticle($data);
    }

    public function updateArticle($id, array $data)
    {
        return $this->articleRepository->updateArticle($id, $data);
    }

    public function deleteArticle($id)
    {
        return $this->articleRepository->deleteArticle($id);
    }
}
