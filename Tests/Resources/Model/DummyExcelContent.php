<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Resources\Model;

use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class DummyExcelContent
 *
 * @package    RichId\ExcelGeneratorBundle\Tests\Resources\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class DummyExcelContent extends ExcelContent
{
    public $property1 = 'First property';

    public $property2 = 2;

    public $property3 = true;
}