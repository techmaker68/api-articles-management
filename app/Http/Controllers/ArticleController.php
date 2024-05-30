<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        return $this->tryCatch(function () {
            return ArticleResource::collection($this->articleService->getAllArticles());
        });
    }

    public function store(StoreArticleRequest $request)
    {
        return $this->tryCatch(function () use ($request) {
            $article = $this->articleService->createArticle($request->validated());
            return new ArticleResource($article);
        });
    }

    public function show($id)
    {
        return $this->tryCatch(function () use ($id) {
            $article = $this->articleService->getArticleById($id);
            return new ArticleResource($article);
        });
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        return $this->tryCatch(function () use ($id, $request) {
            $article = $this->articleService->updateArticle($id, $request->validated());
            return new ArticleResource($article);
        });
    }

    public function destroy($id)
    {
        return $this->tryCatch(function () use ($id) {
            $this->articleService->deleteArticle($id);
            return ArticleResource::collection($this->articleService->getAllArticles());
        });
    }
}
