<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder\Partials;

use RichId\ExcelGeneratorBundle\ConfigurationExtractor\CellConfigurationsExtractor;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;
use RichId\ExcelGeneratorBundle\Event\ExcelRowGeneratedEvent;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class SheetRowContentBuilder
 *
 * @package   RichId\ExcelGeneratorBundle\Builder\Partials
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class SheetRowContentBuilder extends AbstractBuilder
{
    /** @var CellConfigurationsExtractor */
    protected $configurationExtractor;

    public function __construct(CellConfigurationsExtractor $configurationExtractor)
    {
        $this->configurationExtractor = $configurationExtractor;
    }

    public function __invoke(Worksheet $worksheet, ExcelContent $excelContent): void
    {
        $row = (int) $worksheet->getHighestRow();
        $cellConfigurations = $this->configurationExtractor->getCellConfigurations($excelContent);

        foreach ($cellConfigurations as $index => $configuration) {
            $this->buildFromCellConfiguration($worksheet, $configuration, $index + 1, $row);
        }

        $event = new ExcelRowGeneratedEvent($worksheet, $cellConfigurations, $row, $excelContent);
        $this->eventDispatcher->dispatch($event);
    }

    public function buildFromCellConfiguration(Worksheet $worksheet, CellConfiguration $configuration, int $column, int $row): void
    {
        $worksheet->setCellValueByColumnAndRow($column, $row, $configuration->getValue());

        $event = new ExcelCellGeneratedEvent($worksheet, $configuration, $column, $row);
        $this->eventDispatcher->dispatch($event);
    }
}
