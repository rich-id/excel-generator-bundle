<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class ExcelRowGeneratedEvent
 *
 * @package    RichId\ExcelGeneratorBundle\Event
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelRowGeneratedEvent
{
    /** @var int */
    public $row;

    /** @var Worksheet */
    public $worksheet;

    /** @var ExcelContent */
    public $model;

    public function __construct(Worksheet $worksheet, ExcelContent $model, int $row)
    {
        $this->worksheet = $worksheet;
        $this->model = $model;
        $this->row = $row;
    }
}
