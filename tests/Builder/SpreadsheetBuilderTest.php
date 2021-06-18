<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Builder;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilder;
use RichId\ExcelGeneratorBundle\Exception\InvalidExcelSpreadsheetException;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;

/**
 * Class SpreadsheetBuilderTest.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers \RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilder
 */
class SpreadsheetBuilderTest extends TestCase
{
    /** @var SpreadsheetBuilder */
    public $builder;

    public function testBuildInvalidExcelSpreadsheet(): void
    {
        $this->expectException(InvalidExcelSpreadsheetException::class);

        $excelSpreadsheet = new ExcelSpreadsheet();
        ($this->builder)($excelSpreadsheet);
    }

    public function testEmptySpreadsheet(): void
    {
        $excelSpreadsheet = new ExcelSpreadsheet();
        $excelSpreadsheet->filename = 'spreadsheet.xls';

        $spreadsheet = ($this->builder)($excelSpreadsheet);

        self::assertCount(1, $spreadsheet->getAllSheets());
    }

    public function testMultipleEmptySheets(): void
    {
        $excelSpreadsheet = new ExcelSpreadsheet();
        $excelSpreadsheet->filename = 'spreadsheet.xls';

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 1';
        $excelSpreadsheet->addSheet($excelSheet);

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 2';
        $excelSpreadsheet->addSheet($excelSheet);

        $spreadsheet = ($this->builder)($excelSpreadsheet);
        $sheets = $spreadsheet->getAllSheets();

        self::assertCount(2, $sheets);
        self::assertMatch(
            [
                ['title' => 'Sheet 1'],
                ['title' => 'Sheet 2'],
            ],
            $spreadsheet->getAllSheets()
        );
    }

    public function testWithContent(): void
    {
        $excelSpreadsheet = new ExcelSpreadsheet();
        $excelSpreadsheet->filename = 'spreadsheet.xls';

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 1';
        $excelSpreadsheet->addSheet($excelSheet);

        $content = new DummyExcelContent();
        $excelSheet->addChild($content);

        $content = new DummyExcelContent();
        $excelSheet->addChild($content);

        $spreadsheet = ($this->builder)($excelSpreadsheet);
        $sheet = $spreadsheet->getAllSheets()[0] ?? null;
        self::assertInstanceOf(Worksheet::class, $sheet);

        self::assertSame('First property', $sheet->getCell('A2')->getValue());
        self::assertSame(2, $sheet->getCell('B2')->getValue());
        self::assertTrue($sheet->getCell('C2')->getValue());
        self::assertSame('First property', $sheet->getCell('A3')->getValue());
        self::assertSame(2, $sheet->getCell('B3')->getValue());
        self::assertTrue($sheet->getCell('C3')->getValue());
    }
}
