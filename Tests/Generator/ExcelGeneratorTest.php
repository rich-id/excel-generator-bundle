<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Generator;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\Generator\ExcelGenerator;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\Model\DummyExcelContent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ExcelGeneratorTest
 *
 * @package    RichId\ExcelGeneratorBundle\Tests\Generator
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 * @covers RichId\ExcelGeneratorBundle\Generator\ExcelGenerator
 */
final class ExcelGeneratorTest extends TestCase
{
    /** @var ExcelGenerator */
    public $generator;

    /** @var string */
    private $cacheDirectory;

    protected function beforeTest(): void
    {
        $this->cacheDirectory = $this->getService(ParameterBagInterface::class)->get('kernel.cache_dir');
    }

    public function testGenerate(): void
    {
        $filePath = $this->cacheDirectory . '/spreadsheet.xls';

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $excelSpreadsheet = new ExcelSpreadsheet();
        $excelSpreadsheet->filename = 'spreadsheet.xls';

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 1';
        $excelSpreadsheet->addSheet($excelSheet);

        $content = new DummyExcelContent();
        $content->property1 = 'First row';
        $excelSheet->addChild($content);

        $content = new DummyExcelContent();
        $content->property1 = 'Second row';
        $excelSheet->addChild($content);

        $excelSheet = new ExcelSheet();
        $excelSheet->name = 'Sheet 2';
        $excelSpreadsheet->addSheet($excelSheet);

        $content = new DummyExcelContent();
        $content->property1 = 'First row';
        $excelSheet->addChild($content);

        $content = new DummyExcelContent();
        $content->property1 = 'Second row';
        $excelSheet->addChild($content);

        $this->generator->save($excelSpreadsheet, $this->cacheDirectory);

        self::assertFileExists($filePath);
    }
}