<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use RichId\ExcelGeneratorBundle\Annotation\Style;
use RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent;

/**
 * Class AbstractStyleListener.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
abstract class AbstractStyleListener
{
    public function __invoke(ExcelCellGeneratedEvent $event): void
    {
        if ($this->getConfiguration($event) === null) {
            return;
        }

        $items = \sprintf('%s%d', Coordinate::stringFromColumnIndex($event->column), $event->row);
        $style = $event->worksheet->getStyle($items);
        $existingStyle = $style->exportArray();
        $newStyle = $this->editStyle($event, $existingStyle);

        $style->applyFromArray($newStyle);
    }

    abstract protected function editStyle(ExcelCellGeneratedEvent $event, array $style): array;

    protected function getConfiguration(ExcelCellGeneratedEvent $event): ?Style
    {
        return $event->configuration->style;
    }
}
