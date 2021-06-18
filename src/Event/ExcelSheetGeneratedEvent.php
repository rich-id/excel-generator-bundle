<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ExcelSheetGeneratedEvent.
 *
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ExcelSheetGeneratedEvent extends Event
{
    /** @var ExcelSheet */
    protected $model;

    /** @var Worksheet */
    protected $sheet;

    public function __construct(Worksheet $sheet, ExcelSheet $model)
    {
        $this->sheet = $sheet;
        $this->model = $model;
    }

    public function getModel(): ExcelSheet
    {
        return $this->model;
    }

    public function getSheet(): Worksheet
    {
        return $this->sheet;
    }
}
