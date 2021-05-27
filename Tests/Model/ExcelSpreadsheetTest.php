<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Model;

use RichCongress\TestTools\Helper\ForceExecutionHelper;
use RichId\ExcelGeneratorBundle\Model\AbstractExcelNode;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;
use RichId\ExcelGeneratorBundle\Tests\Resources\TestCase\ModelTestCase;

/**
 * Class ExcelSpreadsheetTest
 *
 * @package    RichId\ExcelGeneratorBundle\Tests\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet
 * @covers \RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParent
 * @covers \RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParentValidator
 */
class ExcelSpreadsheetTest extends ModelTestCase
{
    /** @var ExcelSpreadsheet */
    protected $model;

    protected function beforeTest(): void
    {
        $sheet = new ExcelSheet();
        $sheet->name = 'Sheet 1';

        $this->model = new ExcelSpreadsheet();
        $this->model->filename = 'filename.xls';
        $this->model->addSheet($sheet);
    }

    public function testValid(): void
    {
        self::assertEmpty($this->validate());
    }

    public function testNoFilename(): void
    {
        $this->model->filename = null;
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should not be blank.', $violations->get(0)->getMessage());
    }

    public function testNotString(): void
    {
        $this->model->filename = 9;
        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('This value should be of type string.', $violations->get(0)->getMessage());
    }

    public function testBadSheetInstance(): void
    {
        $excelContent = new DummyExcelContent();
        $excelContent->parent = $this->model;

        ForceExecutionHelper::setValue(
            $this->model,
            'sheets',
            [$excelContent]
        );

        $violations = $this->validate();

        self::assertCount(2, $violations);
        self::assertStringContainsString('This value should be of type ' . ExcelSheet::class, $violations->get(0)->getMessage());
        self::assertStringContainsString('This value should be of type ' . AbstractExcelNode::class, $violations->get(1)->getMessage());
    }

    public function testInappropriateParent(): void
    {
        $sheets = $this->model->getSheets()[0];
        $sheets->parent = new ExcelSpreadsheet();

        $violations = $this->validate();

        self::assertCount(1, $violations);
        self::assertSame('The parent is not what is expected, make sure you don\'t use an object twice and don\'t set the parent on your own.', $violations->get(0)->getMessage());
    }
}
