<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Resources\TestCase;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilder;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;

/**
 * Class ListenerTestCase.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 */
abstract class ListenerTestCase extends TestCase
{
    /** @var ExcelSpreadsheet */
    protected $excelSpreadsheet;

    protected function beforeTest(): void
    {
        $this->excelSpreadsheet = new ExcelSpreadsheet();
        $this->excelSpreadsheet->filename = 'spreadsheet.xls';

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 1';
        $this->excelSpreadsheet->addSheet($excelSheet);

        $content = new DummyExcelContent();
        $excelSheet->addChild($content);

        $content = new DummyExcelContent();
        $excelSheet->addChild($content);
    }

    protected function generate(): Spreadsheet
    {
        $builder = $this->getService(SpreadsheetBuilder::class);

        return $builder($this->excelSpreadsheet);
    }
}
