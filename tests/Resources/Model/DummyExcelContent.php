<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Resources\Model;

use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class DummyExcelContent.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class DummyExcelContent extends ExcelContent
{
    /** @var string */
    public $property1 = 'First property';

    /** @var int */
    public $property2 = 2;

    /** @var bool */
    public $property3 = true;
}
