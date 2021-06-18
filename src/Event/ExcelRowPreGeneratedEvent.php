<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Event;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class ExcelRowPreGeneratedEvent.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelRowPreGeneratedEvent
{
    /** @var Worksheet */
    public $worksheet;

    /** @var ExcelContent */
    public $model;

    public function __construct(Worksheet $worksheet, ExcelContent $model)
    {
        $this->worksheet = $worksheet;
        $this->model = $model;
    }
}
