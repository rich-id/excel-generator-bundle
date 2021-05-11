<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class ExcelCellGeneratedEvent
 *
 * @package    RichId\ExcelGeneratorBundle\Event
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelCellGeneratedEvent
{
    /** @var int */
    public $column;

    /** @var int */
    public $row;

    /** @var CellConfiguration */
    public $configuration;

    /** @var Worksheet */
    public $worksheet;

    /** @var ExcelContent */
    public $model;

    public function __construct(Worksheet $worksheet, CellConfiguration $configuration, int $column, int $row)
    {
        $this->worksheet = $worksheet;
        $this->configuration = $configuration;
        $this->model = $configuration->model;
        $this->column = $column;
        $this->row = $row;
    }
}
