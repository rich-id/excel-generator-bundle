<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Builder\Partials\SheetColumnsSizeBuilder;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetHeaderBuilder;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetRowContentBuilder;
use RichId\ExcelGeneratorBundle\Event\SheetGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\SpreadsheetGeneratedEvent;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Exception\InvalidExcelSpreadsheetException;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class SpreadsheetBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class SpreadsheetBuilder implements SpreadsheetBuilderInterface
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var SheetHeaderBuilder */
    protected $sheetHeaderBuilder;

    /** @var SheetRowContentBuilder */
    protected $sheetRowContentBuilder;

    /** @var SheetColumnsSizeBuilder */
    protected $sheetColumnsSizeBuilder;

    /** @var ValidatorInterface */
    protected $validator;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SheetHeaderBuilder $sheetHeaderBuilder,
        SheetRowContentBuilder $sheetRowContentBuilder,
        SheetColumnsSizeBuilder $sheetColumnsSizeBuilder,
        ValidatorInterface $validator
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->sheetHeaderBuilder = $sheetHeaderBuilder;
        $this->sheetRowContentBuilder = $sheetRowContentBuilder;
        $this->sheetColumnsSizeBuilder = $sheetColumnsSizeBuilder;
        $this->validator = $validator;
    }

    public function build(ExcelSpreadsheet $excelSpreadsheet): Spreadsheet
    {
        $violations = $this->validator->validate($excelSpreadsheet);

        if ($violations->count() > 0) {
            throw new InvalidExcelSpreadsheetException($excelSpreadsheet, $violations);
        }

        $sheets = $excelSpreadsheet->getSheets();
        $spreadsheet = new Spreadsheet();

        foreach ($sheets as $index => $sheet) {
            $worksheet = $index === 0 ? $spreadsheet->getSheet(0) : new Worksheet();
            $this->buildSheet($worksheet, $sheet);

            if ($index !== 0) {
                $spreadsheet->addSheet($worksheet, $index);
            }
        }

        $event = SpreadsheetGeneratedEvent::create($spreadsheet);
        $this->eventDispatcher->dispatch($event);

        return $spreadsheet;
    }

    protected function buildSheet(Worksheet $worksheet, ExcelSheet $excelSheet): Worksheet
    {
        $worksheet->setTitle($excelSheet->name);

        foreach ($excelSheet->getChildren() as $child) {
            $this->buildContent($worksheet, $child);
        }

        $event = SheetGeneratedEvent::create($worksheet);
        $this->eventDispatcher->dispatch($event);

        return $worksheet;
    }

    protected function buildContent(Worksheet $worksheet, ExcelContent $excelContent): void
    {
//        if (!$configuration->isWithoutHeader()) {
//            ($this->sheetHeaderBuilder)($sheet, $configuration);
//        }

        ($this->sheetRowContentBuilder)($worksheet, $excelContent);
        $worksheet->setCellValueByColumnAndRow(1, $worksheet->getHighestRow() + 1, '');

        foreach ($excelContent->getChildren() as $child) {
            $this->buildContent($worksheet, $child);
        }

//        ($this->sheetColumnsSizeBuilder)($sheet, $configuration);
    }
}
