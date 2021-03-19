<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Data\Annotation\ColumnMerge;
use RichId\ExcelGeneratorBundle\Data\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Data\Annotation\GroupBorderStyle;
use RichId\ExcelGeneratorBundle\Data\Export;
use RichId\ExcelGeneratorBundle\Data\ExportWithChildren;
use RichId\ExcelGeneratorBundle\Utility\AnnotationReaderTrait;
use RichId\ExcelGeneratorBundle\Utility\CellStyleUtility;
use RichId\ExcelGeneratorBundle\Utility\PropertyUtility;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class SheetRowContentBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SheetRowContentBuilder
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

    public function __invoke(Export $rowContent, Worksheet $sheet, ExcelSheetGeneratorConfiguration $configuration): void
    {
        $currentRow = $sheet->getHighestRow() === 1 ? 2 : $sheet->getHighestRow() + 1;
        $properties = $this->propertyUtility->getPropertiesForConfigAndData($configuration, $rowContent);
//        $from = \sprintf('%s%d', Coordinate::stringFromColumnIndex(1), $currentRow);

        foreach ($properties as $key => $property) {
            $contentStyle = $this->getPropertyAnnotationForProperty($property->getReflectionProperty(), ContentStyle::class);
            $columnMerge = $this->getPropertyAnnotationForProperty($property->getReflectionProperty(), ColumnMerge::class);

            $sheet->setCellValueByColumnAndRow($key + 1, $currentRow, $property->getValue());

            if ($columnMerge instanceof ColumnMerge) {
                $sheet->mergeCellsByColumnAndRow($key + 1, $currentRow, $key + $columnMerge->count, $currentRow);
            }

            if ($contentStyle !== null) {
                $this->cellStyleUtility->setStyleOfDataFor($sheet, $contentStyle, $currentRow, $key + 1, $rowContent);
            }
        }

//        if ($rowContent instanceof ExportWithChildren) {
//            $subConfiguration = $rowContent->getChildConfiguration();
//
//            foreach ($subConfiguration->getRowsContent() as $subRowContent) {
//                ($this)($subRowContent, $sheet, $subConfiguration);
//            }
//        }
//
//        $to = \sprintf('%s%d', Coordinate::stringFromColumnIndex($key ? $key + 1 : 0), $sheet->getHighestRow());
//
//        $groupBorderStyle = $this->getClassAnnotationFor(\get_class($rowContent), GroupBorderStyle::class);
//        if ($groupBorderStyle !== null) {
//            $styleArray = [
//                'borders' => [
//                    'outline' => [
//                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
//                        'color' => ['rgb' => '000000'],
//                    ],
//                ],
//            ];
//
//            $sheet->getStyle(sprintf('%s:%s', $from, $to))->applyFromArray($styleArray);
//        }
    }
}
