<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class LoggerService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggerService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * Log
     * @param $item
     * @param $author
     */
    public function logSuccess($item, $author): void
    {
        $itemType = get_class($item);

        $this->logger->channel('scan')->info("success|type:$itemType|id:$item->id|author:$author->id");
    }

}