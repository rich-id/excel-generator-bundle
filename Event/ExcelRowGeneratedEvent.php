<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
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
    /** @var CellConfiguration[] */
    public $cellConfigurations;

    /** @var ExcelContent */
    public $model;

    /** @var int */
    public $row;

    /** @var Worksheet */
    public $worksheet;

    public function __construct(
        Worksheet $worksheet,
        array $cellConfigurations,
        int $row,
        ?ExcelContent $model = null
    )
    {
        $this->worksheet = $worksheet;
        $this->cellConfigurations = $cellConfigurations;
        $this->row = $row;
        $this->model = $model;
    }
}
