<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder\Partials;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Annotation\ColumnMerge;
use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Data\Export;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Utility\AnnotationReaderTrait;
use RichId\ExcelGeneratorBundle\Utility\CellStyleUtility;
use RichId\ExcelGeneratorBundle\Utility\PropertyUtility;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class SheetRowContentBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder\Partials
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class SheetRowContentBuilder
{
    use AnnotationReaderTrait;

    /** @var CellStyleUtility */
    protected $cellStyleUtility;

    /** @var PropertyUtility */
    protected $propertyUtility;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(CellStyleUtility $cellStyleUtility, PropertyUtility $propertyUtility, EventDispatcherInterface $eventDispatcher)
    {
        $this->cellStyleUtility = $cellStyleUtility;
        $this->propertyUtility = $propertyUtility;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Worksheet $worksheet, ExcelContent $excelContent): void
    {
        $currentRow = $worksheet->getHighestRow();
        $reflectionClass = new \ReflectionClass($excelContent);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $index => $property) {
            if (in_array($property->getName(), ['parent', 'children'], true)) {
                continue;
            }

            $columnPointer = $index + 1;
            $contentStyle = $this->getPropertyAnnotationForProperty($property, ContentStyle::class);
            $columnMerge  = $this->getPropertyAnnotationForProperty($property, ColumnMerge::class);
            $content = $property->getValue($excelContent);

            $worksheet->setCellValueByColumnAndRow($columnPointer, $currentRow, $content);

            if ($columnMerge instanceof ColumnMerge) {
                $worksheet->mergeCellsByColumnAndRow(
                    $columnPointer,
                    $currentRow,
                    $index + $columnMerge->count,
                    $currentRow
                );
            }

            if ($contentStyle !== null) {
                $this->cellStyleUtility->setStyleOfDataFor($worksheet, $contentStyle, $currentRow, $columnPointer, $excelContent);
            }
        }
    }
}
