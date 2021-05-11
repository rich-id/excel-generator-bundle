<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use RichId\ExcelGeneratorBundle\Annotation\ColumnDimension;
use RichId\ExcelGeneratorBundle\Annotation\ColumnsAutoResize;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\CellConfigurationsExtractor;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
use RichId\ExcelGeneratorBundle\Event\ExcelRowGeneratedEvent;
use RichId\ExcelGeneratorBundle\Helper\AnnotationHelper;

/**
 * Class ComputeColumnsSizeOnRowGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ComputeColumnsSizeOnRowGenerated
{
    /** @var CellConfigurationsExtractor */
    protected $cellConfigurationsExtractor;

    public function __construct(CellConfigurationsExtractor $configurationExtractor)
    {
        $this->cellConfigurationsExtractor = $configurationExtractor;
    }

    public function __invoke(ExcelRowGeneratedEvent $event): void
    {
        $this->autoResizeAllColumns($event);
        /** @var CellConfiguration[] $cellConfigurations */
        $cellConfigurations = ($this->cellConfigurationsExtractor)($event->model);

        foreach ($cellConfigurations as $index => $cellConfiguration) {
            $this->resizeColumn($event, $cellConfiguration, $index);
        }
    }

    protected function autoResizeAllColumns(ExcelRowGeneratedEvent $event): void
    {
        $columnsAutoResize = AnnotationHelper::getClassAnnotation($event->model, ColumnsAutoResize::class);

        if ($columnsAutoResize === null) {
            return;
        }

        $cellIterator = $event->worksheet->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $column = $cell->getColumn();
            $columnDimension = $event->worksheet->getColumnDimension($column);

            if ($columnDimension !== null) {
                $columnDimension->setAutoSize(true);
            }
        }
    }

    protected function resizeColumn(
        ExcelRowGeneratedEvent $event,
        CellConfiguration $cellConfiguration,
        int $column
    ): void
    {
        $columnDimensionAnnotation = $cellConfiguration->getAnnotation(ColumnDimension::class);

        if (!$columnDimensionAnnotation instanceof ColumnDimension) {
            return;
        }

        $columnIndex = Coordinate::stringFromColumnIndex($column);
        $columnDimension = $event->worksheet->getColumnDimension($columnIndex);

        if ($columnDimension === null) {
            return;
        }

        if ($columnDimensionAnnotation->autoResize) {
            $columnDimension->setAutoSize(true);
            return;
        }

        if ($columnDimensionAnnotation->dimension !== null) {
            $columnDimension->setWidth($columnDimensionAnnotation->dimension);
        }
    }
}
