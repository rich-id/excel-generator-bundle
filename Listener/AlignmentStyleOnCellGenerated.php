<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;
use RichId\ExcelGeneratorBundle\Helper\ArrayHelper;

/**
 * Class AlignmentStyleOnCellGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
final class AlignmentStyleOnCellGenerated extends AbstractStyleListener
{
    protected function editStyle(ExcelCellGeneratedEvent $event, array $style): array
    {
        /** @var Style $config */
        $config = $this->getConfiguration($event);
        $newStyles = [
            $this->getHorizontalAlignment($config),
            $this->getVerticalAlignment($config),
            $this->getTextWrapping($config)
        ];

        foreach ($newStyles as $newStyle) {
            $style = ArrayHelper::mergeOptions($style, $newStyle);
        }

        return $style;
    }

    protected function getHorizontalAlignment(Style $config): array
    {
        if (!$config->hasAllowedPosition()) {
            return [];
        }

        return [
            'alignment' => [
                'horizontal' => $config->position,
            ]
        ];
    }

    protected function getVerticalAlignment(Style $config): array
    {
        if (!$config->hasAllowedVerticalPosition()) {
            return [];
        }

        return [
            'alignment' => [
                'vertical' => $config->verticalPosition,
            ]
        ];
    }

    protected function getTextWrapping(Style $config): array
    {
        if ($config->wrapText !== true) {
            return [];
        }

        return [
            'alignment' => [
                'wrapText' => $config->wrapText,
            ]
        ];
    }
}
