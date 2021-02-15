<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Event\PostSheetGenerationEvent;
use RichId\ExcelGeneratorBundle\Event\PostSpreadsheetGenerationEvent;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class SpreadsheetBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SpreadsheetBuilder implements SpreadsheetBuilderInterface
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var SheetHeaderBuilder */
    protected $sheetHeaderBuilder;

    /** @var SheetRowContentBuilder */
    protected $sheetRowContentBuilder;

    /** @var SheetAutoResizeBuilder */
    protected $sheetAutoResizeBuilder;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SheetHeaderBuilder $sheetHeaderBuilder,
        SheetRowContentBuilder $sheetRowContentBuilder,
        SheetAutoResizeBuilder $sheetAutoResizeBuilder
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->sheetHeaderBuilder = $sheetHeaderBuilder;
        $this->sheetRowContentBuilder = $sheetRowContentBuilder;
        $this->sheetAutoResizeBuilder = $sheetAutoResizeBuilder;
    }

    public function buildSpreadsheet(array $sheets): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $worksheetCounter = 0;

        /** @var ExcelSheetGeneratorConfiguration $sheet */
        foreach ($sheets as $sheetName => $sheet) {
            if ($worksheetCounter > 0) {
                $worksheet = new Worksheet();
                $worksheet->setTitle((string) $sheetName);
                $spreadsheet->addSheet($worksheet, $worksheetCounter);
                $spreadsheet->setActiveSheetIndex($worksheetCounter);
            }

            $this->addSheetIn($spreadsheet->getActiveSheet(), $sheet);
            $this->eventDispatcher->dispatch(PostSheetGenerationEvent::create($spreadsheet->getActiveSheet()));

            $worksheetCounter ++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $this->eventDispatcher->dispatch(PostSpreadsheetGenerationEvent::create($spreadsheet));

        return $spreadsheet;
    }

    private function addSheetIn(Worksheet $sheet, ExcelSheetGeneratorConfiguration $configuration): void
    {
        if (!$configuration->isWithoutHeader()) {
            ($this->sheetHeaderBuilder)($sheet, $configuration);
        }

        foreach ($configuration->getRowsContent() as $rowContent) {
            ($this->sheetRowContentBuilder)($rowContent, $sheet, $configuration);
        }

        if ($configuration->isAutoResize()) {
            ($this->sheetAutoResizeBuilder)($sheet);
        }
    }
}
