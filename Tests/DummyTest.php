<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests;

use RichCongress\Bundle\UnitBundle\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\RichIdExcelGeneratorBundle;

/**
 * Class DummyTest
 *
 * @package   RichId\ExcelGeneratorBundle\Tests
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class DummyTest extends TestCase
{
    public function testInstanciateBundle(): void
    {
        $bundle = new RichIdExcelGeneratorBundle();

        self::assertInstanceOf(RichIdExcelGeneratorBundle::class, $bundle);
    }
}
