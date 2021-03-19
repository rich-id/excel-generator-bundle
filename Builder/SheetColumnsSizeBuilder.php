<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Data\Annotation\ColumnDimension;
use RichId\ExcelGeneratorBundle\Data\Annotation\ColumnsAutoResize;
use RichId\ExcelGeneratorBundle\Utility\AnnotationReaderTrait;
use RichId\ExcelGeneratorBundle\Utility\PropertyUtility;

/**
 * Class SheetColumnsSizeBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SheetColumnsSizeBuilder
{
    use AnnotationReaderTrait;

    /** @var PropertyUtility */
    protected $propertyUtility;

    public function __construct(PropertyUtility $propertyUtility)
    {
        $this->propertyUtility = $propertyUtility;
    }

    public function __invoke(Worksheet $sheet, ExcelSheetGeneratorConfiguration $configuration): void
    {
        $columnsAutoResize = $this->getClassAnnotationFor($configuration->getClass(), ColumnsAutoResize::class);
        $properties = $this->propertyUtility->getPropertiesForConfig($configuration);

        if ($columnsAutoResize instanceof ColumnsAutoResize) {
            $this->autoResizeAllColumns($sheet);
        }

        foreach ($properties as $key => $property) {
            /** @var ColumnDimension $columnDimension */
            $columnDimension = $this->getPropertyAnnotationForProperty($property->getReflectionProperty(), ColumnDimension::class);

            if (!$columnDimension instanceof ColumnDimension) {
                continue;
            }

            if ($columnDimension->autoResize) {
                $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($key + 1))->setAutoSize(true);
            } else if ($columnDimension->dimension !== null) {
                $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($key + 1))->setWidth($columnDimension->dimension);
            }
        }
    }

    private function autoResizeAllColumns(Worksheet $sheet): void
    {
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }
    }
}
