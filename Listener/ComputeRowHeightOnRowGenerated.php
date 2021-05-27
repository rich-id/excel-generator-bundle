<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\CellConfigurationsExtractor;
use RichId\ExcelGeneratorBundle\Event\ExcelRowGeneratedEvent;

/**
 * Class ComputeRowHeightOnRowGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ComputeRowHeightOnRowGenerated
{
    public const ROW_HEIGHT_MULTIPLICATOR = 1.4;
    
    /** @var CellConfigurationsExtractor */
    protected $cellConfigurationsExtractor;

    public function __construct(CellConfigurationsExtractor $configurationExtractor)
    {
        $this->cellConfigurationsExtractor = $configurationExtractor;
    }

    public function __invoke(ExcelRowGeneratedEvent $event): void
    {
        $cellConfigurations = $event->cellConfigurations ?? $this->cellConfigurationsExtractor->getCellConfigurations($event->model);
        $maxFontSize = 0;

        foreach ($cellConfigurations as $cellConfiguration) {
            /** @var Style $config */
            $config = $cellConfiguration->style;
            $fontSize = $config->fontSize ?? 0;
            $maxFontSize = max($maxFontSize, $fontSize);
        }

        $rowDimension = $event->worksheet->getRowDimension($event->row);

        if ($rowDimension !== null && $maxFontSize !== 0) {
            $rowDimension->setRowHeight($maxFontSize * self::ROW_HEIGHT_MULTIPLICATOR);
        }
    }
}
