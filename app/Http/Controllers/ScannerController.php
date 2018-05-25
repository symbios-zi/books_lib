<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScannerRequest;
use App\Services\BookService;
use App\Services\CdService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    /**
     * @var BookService
     */
    private $bookService;
    /**
     * @var CdService
     */
    private $cdService;

    /**
     * @param BookService $bookService
     * @param CdService $cdService
     */
    public function __construct(BookService $bookService, CdService $cdService)
    {
        $this->bookService = $bookService;
        $this->cdService = $cdService;
    }
    
    public function store(ScannerRequest $request): JsonResponse
    {
        $createdItem = $this->createDependOnCondition($request);

        return new JsonResponse([
            'id' => $createdItem->id,
            'success' => true
        ], 201);
    }

    /**
     * @param Request $request
     * @return \App\Book|\App\Cd
     */
    private function createDependOnCondition(Request $request)
    {
        if ($request->has('isbn')) {
            return $this->bookService->add($request->all());
        }

        return $this->cdService->add($request->all());
    }
}
