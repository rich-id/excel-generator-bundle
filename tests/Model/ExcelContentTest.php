<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Model;

use RichCongress\TestTools\Helper\ForceExecutionHelper;
use RichId\ExcelGeneratorBundle\Model\AbstractExcelNode;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;
use RichId\ExcelGeneratorBundle\Tests\Resources\TestCase\ModelTestCase;

/**
 * Class ExcelContentTest
 *
 * @package    RichId\ExcelGeneratorBundle\Tests\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Model\AbstractExcelNode
 * @covers \RichId\ExcelGeneratorBundle\Model\ExcelContent
 */
class ExcelContentTest extends ModelTestCase
{
    /** @var ExcelContent */
    protected $model;

    public function testValid(): void
    {
        self::assertEmpty($this->validate());
        self::assertCount(2, $this->model->getChildren());
    }

    public function testMissingParent(): void
    {
        $this->model->parent = null;
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should not be null.', $violations->get(0)->getMessage());
    }

    public function testBadInstanceOfParent(): void
    {
        $this->model->parent = new ExcelSpreadsheet();
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should be of type RichId\ExcelGeneratorBundle\Model\AbstractExcelNode.', $violations->get(0)->getMessage());
    }

    public function testParentIsContent(): void
    {
        $this->model->parent = new ExcelContent();
        $violations = $this->validate();

        self::assertEmpty($violations);
    }

    protected function beforeTest(): void
    {
        $this->model = new ExcelContent();
        $this->model->parent = new ExcelSheet();
        $this->model->addChild(new ExcelContent());
        $this->model->addChild(new ExcelContent());
    }
}
