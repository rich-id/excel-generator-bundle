<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Model;

use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\TestCase\ModelTestCase;

/**
 * Class ExcelSheetTest.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Model\AbstractExcelNode
 * @covers \RichId\ExcelGeneratorBundle\Model\ExcelSheet
 */
class ExcelSheetTest extends ModelTestCase
{
    /** @var ExcelSheet */
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
        $this->model->parent = new ExcelContent();
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should be of type RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet.', $violations->get(0)->getMessage());
    }

    public function testBlankName(): void
    {
        $this->model->name = '';
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should not be blank.', $violations->get(0)->getMessage());
    }

    protected function beforeTest(): void
    {
        $this->model = new ExcelSheet();
        $this->model->name = 'Sheet 1';
        $this->model->parent = new ExcelSpreadsheet();
        $this->model->addChild(new ExcelContent());
        $this->model->addChild(new ExcelContent());
    }
}
