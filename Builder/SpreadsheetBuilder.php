<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Data\ExportWithChildren;
use RichId\ExcelGeneratorBundle\Event\SheetGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\SpreadsheetGeneratedEvent;
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

    /** @var SheetColumnsSizeBuilder */
    protected $sheetColumnsSizeBuilder;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SheetHeaderBuilder $sheetHeaderBuilder,
        SheetRowContentBuilder $sheetRowContentBuilder,
        SheetColumnsSizeBuilder $sheetColumnsSizeBuilder
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->sheetHeaderBuilder = $sheetHeaderBuilder;
        $this->sheetRowContentBuilder = $sheetRowContentBuilder;
        $this->sheetColumnsSizeBuilder = $sheetColumnsSizeBuilder;
    }

    public function buildSpreadsheet(array $sheets): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $worksheetCounter = 0;

        foreach ($sheets as $sheetName => $sheet) {
            if ($worksheetCounter > 0) {
                $worksheet = new Worksheet();
                $worksheet->setTitle((string) $sheetName);
                $spreadsheet->addSheet($worksheet, $worksheetCounter);
                $spreadsheet->setActiveSheetIndex($worksheetCounter);
            }

            $this->addSheetIn($spreadsheet->getActiveSheet(), $this->getConfigurations($sheet));
            $spreadsheet->getActiveSheet()->removeRow(1);

            $this->eventDispatcher->dispatch(SheetGeneratedEvent::create($spreadsheet->getActiveSheet()));

            $worksheetCounter ++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $this->eventDispatcher->dispatch(SpreadsheetGeneratedEvent::create($spreadsheet));

        return $spreadsheet;
    }

    private function addSheetIn(Worksheet $sheet, array $configurations): void
    {
        $lastIndex = \array_key_last($configurations);

        foreach ($configurations as $index => $configuration) {
            if (!$configuration->isWithoutHeader()) {
                ($this->sheetHeaderBuilder)($sheet, $configuration);
            }

            foreach ($configuration->getRowsContent() as $rowContent) {
                ($this->sheetRowContentBuilder)($rowContent, $sheet, $configuration);

                if ($rowContent instanceof ExportWithChildren) {
                    $this->addSheetIn($sheet, [$rowContent->getChildConfiguration()]);
                }
            }

            ($this->sheetColumnsSizeBuilder)($sheet, $configuration);

            if ($index !== $lastIndex) {
                $sheet->setCellValueByColumnAndRow(1, $sheet->getHighestRow() + 1, '');
            }
        }
    }

    private function getConfigurations($config): array
    {
        if ($config instanceof ExcelSheetGeneratorConfiguration) {
            return [$config];
        }

        if (!\is_iterable($config)) {
            throw new \InvalidArgumentException();
        }

        $configurations = [];

        foreach ($config as $configuration) {
            if (!$configuration instanceof ExcelSheetGeneratorConfiguration) {
                throw new \InvalidArgumentException();
            }

            $configurations[] = $configuration;
        }

        return $configurations;
    }
}
