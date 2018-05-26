<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var AuthorService
     */
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function top(): JsonResponse
    {
        $top = $this->authorService->top();
        return new JsonResponse($top);
    }

    public function average(Request $request)
    {
        $authorName = $request->get('author_full_name');

        $years = $this->authorService->collectAverageByYearFor($authorName);

        return new JsonResponse($years);
    }

}
