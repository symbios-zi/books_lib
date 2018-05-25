<?php

namespace App\Http\Controllers;

use App\Services\CdService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CdAddRequest;
use App\Services\FiltersService\CdsFilters;

class CdController extends Controller
{

    /**
     * @var CdService
     */
    private $cdService;

    /**
     * CdController constructor.
     * @param CdService $cdService
     */
    public function __construct(CdService $cdService)
    {
        $this->cdService = $cdService;
    }

    public function index(CdsFilters $cdsFilters): JsonResponse
    {
        $cds = $this->cdService->search($cdsFilters);

        return new JsonResponse($cds);
    }
}
