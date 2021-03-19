<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SheetGeneratedEvent
 *
 * @package   RichId\ExcelGeneratorBundle\Event
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SheetGeneratedEvent extends Event
{
    /** @var Worksheet */
    protected $sheet;

    private function __construct()
    {
    }

    public static function create(Worksheet $sheet): self
    {
        $event = new self();

        $event->sheet = $sheet;

        return $event;
    }

    public function getSheet(): Worksheet
    {
        return $this->sheet;
    }
}
