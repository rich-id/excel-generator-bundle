<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Generator;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\Generator\ExcelGenerator;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ExcelGeneratorTest.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers \RichId\ExcelGeneratorBundle\Generator\ExcelGenerator
 */
final class ExcelGeneratorTest extends TestCase
{
    /** @var ExcelGenerator */
    public $generator;

    /** @var string */
    private $cacheDirectory;

    public function testGenerate(): void
    {
        $excelSpreadsheet = $this->generateExcelSpreadsheet();
        $filePath = $this->cacheDirectory . '/' . $excelSpreadsheet->filename;

        if (\file_exists($filePath)) {
            \unlink($filePath);
        }

        $this->generator->save($excelSpreadsheet, $this->cacheDirectory);

        self::assertFileExists($filePath);
    }

    protected function beforeTest(): void
    {
        $this->cacheDirectory = $this->getService(ParameterBagInterface::class)->get('kernel.cache_dir');
    }

    private function generateExcelSpreadsheet(): ExcelSpreadsheet
    {
        $content1 = new DummyExcelContent();
        $content1->property1 = 'First row';
        $content2 = new DummyExcelContent();
        $content2->property1 = 'Second row';

        $excelSheet1 = new ExcelSheet();
        $excelSheet1->name = 'Sheet 1';
        $excelSheet1->addChild($content1);
        $excelSheet1->addChild($content2);

        $childContent = new DummyExcelContent();
        $childContent->property1 = 'Child';
        $parentContent = new DummyExcelContent();
        $parentContent->property1 = 'Parent';
        $parentContent->addChild($childContent);

        $excelSheet2 = new ExcelSheet();
        $excelSheet2->name = 'Sheet 2';
        $excelSheet2->addChild($parentContent);

        $excelSpreadsheet = new ExcelSpreadsheet();
        $excelSpreadsheet->filename = 'spreadsheet.xls';
        $excelSpreadsheet->addSheet($excelSheet1);
        $excelSpreadsheet->addSheet($excelSheet2);

        return $excelSpreadsheet;
    }
}
