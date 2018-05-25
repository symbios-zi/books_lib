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
        $itemType = $this->generateItemCode($item);

        $this->logger
            ->channel('scan')
            ->info("success|type:$itemType|id:$item->id|author:$author->id");
    }

    /**
     * Log
     * @param array $errors
     */
    public function logError(array $errors): void
    {
        $formattedErrors = $this->formatErrors($errors);

        $this->logger
            ->channel('scan')
            ->error($formattedErrors);
    }

    /**
     * @param $item
     * @return string
     */
    private function generateItemCode($item): string
    {
        return strtolower((new \ReflectionClass($item))->getShortName());
    }

    /**
     * @param $errors
     * @return string
     */
    private function formatErrors($errors): string
    {
        $formatted = "";
        foreach($errors as $parameter => $errorsList) {
            foreach ($errorsList as $message) {
                $formatted .= "$message|";
            }
        }

        return $formatted;
    }

}