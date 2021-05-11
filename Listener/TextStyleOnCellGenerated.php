<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;
use RichId\ExcelGeneratorBundle\Helper\ExpressionLanguageHelper;

/**
 * Class TextStyleOnCellGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class TextStyleOnCellGenerated extends AbstractStyleListener
{
    protected function editStyle(ExcelCellGeneratedEvent $event, array $style): array
    {
        /** @var Style $config */
        $config = $this->getConfiguration($event);

        return array_merge(
            $style,
            $this->getBoldStyle($config),
            $this->getColorStyle($config, $event),
            $this->getFontSizeStyle($config)
        );
    }

    protected function getBoldStyle(Style $config): array
    {
        if ($config->bold === null) {
            return [];
        }

        return [
            'font' => [
                'bold' => $config->bold,
            ],
        ];
    }

    protected function getColorStyle(Style $config, ExcelCellGeneratedEvent $event): array
    {
        if ($config->color === null) {
            return [];
        }

        $hexCode = ExpressionLanguageHelper::evaluate($config->color, $event->model);

        return [
            'font' => [
                'color' => [
                    'rgb' => \str_replace('#', '', $hexCode),
                ],
            ],
        ];
    }

    protected function getFontSizeStyle(Style $config): array
    {
        if ($config->fontSize === null) {
            return [];
        }

        return [
            'font' => [
                'size' => $config->fontSize,
            ],
        ];
    }
}
