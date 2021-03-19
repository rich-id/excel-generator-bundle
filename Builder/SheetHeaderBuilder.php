<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Data\Annotation\HeaderStyle;
use RichId\ExcelGeneratorBundle\Data\Annotation\HeaderTitle;
use RichId\ExcelGeneratorBundle\Utility\AnnotationReaderTrait;
use RichId\ExcelGeneratorBundle\Utility\CellStyleUtility;
use RichId\ExcelGeneratorBundle\Utility\PropertyUtility;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SheetHeaderBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SheetHeaderBuilder
{
    use AnnotationReaderTrait;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var CellStyleUtility */
    protected $cellStyleUtility;

    /** @var PropertyUtility */
    protected $propertyUtility;

    public function __construct(TranslatorInterface $translator, CellStyleUtility $cellStyleUtility, PropertyUtility $propertyUtility)
    {
        $this->translator = $translator;
        $this->cellStyleUtility = $cellStyleUtility;
        $this->propertyUtility = $propertyUtility;
    }

    public function __invoke(Worksheet $sheet, ExcelSheetGeneratorConfiguration $configuration): void
    {
        $currentRow = $sheet->getHighestRow() === 1 ? 2 : $sheet->getHighestRow() + 1;
        $properties = $this->propertyUtility->getPropertiesForConfig($configuration);

        /** @var HeaderStyle $headerStyle */
        $headerStyle = $this->getClassAnnotationFor($configuration->getClass(), HeaderStyle::class);
        $hasHeader = false;
        $headerCustomStyles = [];

        foreach ($properties as $key => $property) {
            /** @var HeaderTitle $headerTitle */
            $headerTitle = $this->getPropertyAnnotationForProperty($property->getReflectionProperty(), HeaderTitle::class);
            $headerCustomStyles[$key] = $headerTitle !== null && $headerTitle->hasStyle() ? $headerTitle : null;

            if ($headerTitle !== null) {
                $hasHeader = true;
                $sheet->setCellValueByColumnAndRow($key + 1, $currentRow, $this->getHeaderTitle($headerTitle));
            }
        }

        if ($hasHeader && $headerStyle !== null && $headerStyle->hasStyle()) {
            $this->cellStyleUtility->setStyleFor($sheet, $headerStyle, $currentRow, 1, \count($properties));
        }

        foreach ($headerCustomStyles as $key => $headerCustomStyle) {
            if ($headerCustomStyle === null) {
                continue;
            }

            $this->cellStyleUtility->setStyleFor($sheet, $headerCustomStyle, 1, $key + 1);
        }
    }

    private function getHeaderTitle(HeaderTitle $headerTitle): string
    {
        if ($headerTitle->translationKey !== null) {
            return $this->translator->trans($headerTitle->translationKey);
        }

        return $headerTitle->title !== null ? $headerTitle->title : '';
    }
}
