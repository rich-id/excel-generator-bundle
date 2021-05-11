<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ExcelSpreadsheetGeneratedEvent
 *
 * @package   RichId\ExcelGeneratorBundle\Event
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ExcelSpreadsheetGeneratedEvent extends Event
{
    /** @var ExcelSpreadsheet */
    protected $model;

    /** @var Spreadsheet */
    protected $spreadsheet;

    public function __construct(Spreadsheet $spreadsheet, ExcelSpreadsheet $model)
    {
        $this->spreadsheet = $spreadsheet;
        $this->model = $model;
    }

    public function getModel(): ExcelSpreadsheet
    {
        return $this->model;
    }

    public function getSpreadsheet(): Spreadsheet
    {
        return $this->spreadsheet;
    }
}
