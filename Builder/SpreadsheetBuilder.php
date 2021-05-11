<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Builder\Partials\AbstractBuilder;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetColumnsSizeBuilder;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetHeaderBuilder;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetRowContentBuilder;
use RichId\ExcelGeneratorBundle\Event\ExcelRowGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\ExcelRowPreGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\ExcelSheetGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\ExcelSpreadsheetGeneratedEvent;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Exception\InvalidExcelSpreadsheetException;
use RichId\ExcelGeneratorBundle\Helper\SpreadsheetHelper;
use RichId\ExcelGeneratorBundle\Helper\WorksheetHelper;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SpreadsheetBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class SpreadsheetBuilder extends AbstractBuilder implements SpreadsheetBuilderInterface
{
    /** @var SheetHeaderBuilder */
    protected $sheetHeaderBuilder;

    /** @var SheetRowContentBuilder */
    protected $sheetRowContentBuilder;

    /** @var ValidatorInterface */
    protected $validator;

    public function __construct(
        SheetHeaderBuilder $sheetHeaderBuilder,
        SheetRowContentBuilder $sheetRowContentBuilder,
        ValidatorInterface $validator
    )
    {
        $this->sheetHeaderBuilder = $sheetHeaderBuilder;
        $this->sheetRowContentBuilder = $sheetRowContentBuilder;
        $this->validator = $validator;
    }

    public function __invoke(ExcelSpreadsheet $excelSpreadsheet): Spreadsheet
    {
        $violations = $this->validator->validate($excelSpreadsheet);

        if ($violations->count() > 0) {
            throw new InvalidExcelSpreadsheetException($excelSpreadsheet, $violations);
        }

        $spreadsheet = new Spreadsheet();
        $sheets = $excelSpreadsheet->getSheets();

        foreach ($sheets as $index => $sheet) {
            $worksheet = SpreadsheetHelper::getOrCreateWorksheet($spreadsheet, $index);
            $this->buildSheet($worksheet, $sheet);
        }

        $event = new ExcelSpreadsheetGeneratedEvent($spreadsheet, $excelSpreadsheet);
        $this->eventDispatcher->dispatch($event);

        return $spreadsheet;
    }

    protected function buildSheet(Worksheet $worksheet, ExcelSheet $excelSheet): Worksheet
    {
        $worksheet->setTitle($excelSheet->name);

        foreach ($excelSheet->getChildren() as $child) {
            $this->buildContent($worksheet, $child);
        }

        $event = new ExcelSheetGeneratedEvent($worksheet, $excelSheet);
        $this->eventDispatcher->dispatch($event);

        return $worksheet;
    }

    protected function buildContent(Worksheet $worksheet, ExcelContent $excelContent): void
    {
        $event = new ExcelRowPreGeneratedEvent($worksheet, $excelContent);
        $this->eventDispatcher->dispatch($event);

        ($this->sheetRowContentBuilder)($worksheet, $excelContent);
        WorksheetHelper::newLine($worksheet);

        foreach ($excelContent->getChildren() as $child) {
            $this->buildContent($worksheet, $child);
        }
    }
}
