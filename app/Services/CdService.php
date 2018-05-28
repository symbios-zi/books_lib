<?php

namespace App\Services;

use App\Author;
use App\Cd;
use App\Services\FiltersService\CdsFilters;
use Exception;
use Illuminate\Database\Connection;
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
     * @var Connection
     */
    private $databaseManager;

    /**
     * CdService constructor.
     * @param Cd $cdModel
     * @param LoggerService $loggerService
     * @param Author $authorModel
     * @param Connection $databaseManager
     */
    public function __construct(
        Cd $cdModel,
        LoggerService $loggerService,
        Author $authorModel,
        Connection $databaseManager
    ) {
        $this->cdModel = $cdModel;
        $this->loggerService = $loggerService;
        $this->authorModel = $authorModel;
        $this->databaseManager = $databaseManager;
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
     * @throws Exception
     */
    public function add($fields): Cd
    {
        try {
            $this->databaseManager->beginTransaction();

            if(empty($fields['author_name'])) {
                throw new Exception('author_name field is required.');
            }

            $author = $this->authorModel->firstOrCreate(['name' => $fields['author_name']]);

            $book = new Cd();
            $book->fill($fields);
            $book->author()->associate($author);
            $book->save();

            $this->loggerService->logSuccess($book, $author);

            $this->databaseManager->commit();

            return $book;
        } catch (\Exception $e) {
            $this->databaseManager->rollBack();
            throw new Exception('Item did not added');
        }
    }
}