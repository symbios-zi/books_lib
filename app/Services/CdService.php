<?php

namespace App\Services;

use App\Author;
use App\Cd;
use App\Services\FiltersService\CdsFilters;
use Illuminate\Support\Collection;

class CdService
{
    /**
     * @var Cd
     */
    private $cdModel;
    /**
     * @var LoggerService
     */
    private $loggerService;
    /**
     * @var Author
     */
    private $authorModel;

    /**
     * CdService constructor.
     * @param Cd $cdModel
     * @param LoggerService $loggerService
     * @param Author $authorModel
     */
    public function __construct(Cd $cdModel, LoggerService $loggerService, Author $authorModel)
    {
        $this->cdModel = $cdModel;
        $this->loggerService = $loggerService;
        $this->authorModel = $authorModel;
    }

    /**
     * @param CdsFilters $filters
     * @return Collection|null
     */
    public function search(CdsFilters $filters): ?Collection
    {
        return $this->cdModel
            ->select('title','year', 'created_at')
            ->filter($filters)
            ->get();
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function add($fields): Cd
    {
        $author = $this->authorModel->firstOrCreate(['name' => $fields['author_name']]);

        $cd = new Cd();
        $cd->fill($fields);
        $cd->author()->associate($author);
        $cd->save();

        $this->loggerService->logSuccess($cd, $author);


        return $cd;
    }
}