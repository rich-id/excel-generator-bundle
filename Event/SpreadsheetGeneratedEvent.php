<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SpreadsheetGeneratedEvent
 *
 * @package   RichId\ExcelGeneratorBundle\Event
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class SpreadsheetGeneratedEvent extends Event
{
    /** @var Spreadsheet */
    protected $spreadsheet;

    private function __construct()
    {
    }

    public static function create(Spreadsheet $spreadsheet): self
    {
        $event = new self();

        $event->spreadsheet = $spreadsheet;

        return $event;
    }

    public function getSpreadsheet(): Spreadsheet
    {
        return $this->spreadsheet;
    }
}
