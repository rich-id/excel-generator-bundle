<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Exception;

use RichId\ExcelGeneratorBundle\Data\Export;

/**
 * Class NotSupportedExportDataException
 *
 * @package   RichId\ExcelGeneratorBundle\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class NotSupportedExportDataException extends \Exception implements ExcelExportException
{
    public function __construct(string $className)
    {
        parent::__construct(
            \sprintf(
                'The class "%s" cannot be used to generate an excel export. Check that your class extends the %s class.',
                $className,
                Export::class
            )
        );
    }
}
