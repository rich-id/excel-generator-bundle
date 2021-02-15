<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class SheetAutoResizeBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SheetAutoResizeBuilder
{
    public function __invoke(Worksheet $sheet): void
    {
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }
    }
}
