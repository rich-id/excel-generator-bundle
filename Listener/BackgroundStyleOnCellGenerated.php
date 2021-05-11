<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;
use RichId\ExcelGeneratorBundle\Helper\ExpressionLanguageHelper;

/**
 * Class BoldStyleOnCellGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class BackgroundStyleOnCellGenerated extends AbstractStyleListener
{
    protected function editStyle(ExcelCellGeneratedEvent $event, array $style): array
    {
        /** @var Style $config */
        $config = $this->getConfiguration($event);

        if ($config->backgroundColor === null) {
            return $style;
        }

        $hexCode = ExpressionLanguageHelper::evaluate($config->backgroundColor, $event->model);

        if ($hexCode === null) {
            return $style;
        }

        $style['fill'] = [
            'fillType'   => Fill::FILL_SOLID,
            'startColor' => ['rgb' => \str_replace('#', '', $hexCode)]
        ];

        return $style;
    }
}
