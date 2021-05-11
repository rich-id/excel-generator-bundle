<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use PhpOffice\PhpSpreadsheet\Style\Border;
use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;

/**
 * Class BorderStyleOnCellGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class BorderStyleOnCellGenerated extends AbstractStyleListener
{
    protected function editStyle(ExcelCellGeneratedEvent $event, array $style): array
    {
        /** @var Style $config */
        $config = $this->getConfiguration($event);

        if (!$config->hasAllowedBorder()) {
            return $style;
        }

        $borderStyle = $config->hasAllowedBorderStyle() ? $config->borderStyle : Border::BORDER_HAIR;
        $style['borders'] = [];

        foreach ($config->border as $border) {
            $style['borders'][$border] = [
                'borderStyle' => $borderStyle,
                'color'       => ['rgb' => $config->borderColor],
            ];
        }

        return $style;
    }
}
