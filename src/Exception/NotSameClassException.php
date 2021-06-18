<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Exception;

/**
 * Class NotSameClassException.
 *
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class NotSameClassException extends \Exception implements ExcelExportException
{
    public function __construct(string $className, string $expectedClassName)
    {
        parent::__construct(
            \sprintf(
                'The class must be an instance of "%s", "%s" given',
                $expectedClassName,
                $className
            )
        );
    }
}
