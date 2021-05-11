<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;

/**
 * Class ColumnMergingOnCellGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ColumnMergingOnCellGenerated
{
    public function __invoke(ExcelCellGeneratedEvent $event): void
    {
        if ($event->configuration->columnMerge === null) {
            return;
        }

        $startColumn = $event->column;
        $endColumn = $event->column + $event->configuration->columnMerge->count - 1;
        $row = $event->row;

        $event->worksheet->mergeCellsByColumnAndRow($startColumn, $row, $endColumn, $row);
    }
}
