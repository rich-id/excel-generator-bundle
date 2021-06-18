<?php declare(strict_types=1);

namespace Listener;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\TestCase\ListenerTestCase;

/**
 * Class TextStyleOnCellGeneratedTest
 *
 * @package    Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @
 * @covers \RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent
 * @covers \RichId\ExcelGeneratorBundle\Listener\TextStyleOnCellGenerated
 */
final class TextStyleOnCellGeneratedTest extends ListenerTestCase
{
    public function testBoldStyle(): void
    {
        $spreadsheet = $this->generate();
        $sheet = $spreadsheet->getAllSheets()[0] ?? null;
        self::assertInstanceOf(Worksheet::class, $sheet);

        self::assertTrue($sheet->getCell('D2')->getStyle()->getFont()->getBold());
        self::assertFalse($sheet->getCell('A2')->getStyle()->getFont()->getBold());
    }

    public function testColorStyle(): void
    {
        $spreadsheet = $this->generate();
        $sheet = $spreadsheet->getAllSheets()[0] ?? null;
        self::assertInstanceOf(Worksheet::class, $sheet);

        self::assertSame('FFFFFF', $sheet->getCell('E2')->getStyle()->getFont()->getColor()->getRGB());
        self::assertSame('EEEEEE', $sheet->getCell('F2')->getStyle()->getFont()->getColor()->getRGB());
        self::assertSame('000000', $sheet->getCell('A2')->getStyle()->getFont()->getColor()->getRGB());
    }

    public function testFontSizeStyle(): void
    {
        $spreadsheet = $this->generate();
        $sheet = $spreadsheet->getAllSheets()[0] ?? null;
        self::assertInstanceOf(Worksheet::class, $sheet);

        self::assertSame(34.0, $sheet->getCell('G2')->getStyle()->getFont()->getSize());
        self::assertSame(11, $sheet->getCell('A2')->getStyle()->getFont()->getSize());
    }
}
