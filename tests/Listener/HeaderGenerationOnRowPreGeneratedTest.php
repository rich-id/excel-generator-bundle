<?php

declare(strict_types=1);

namespace Listener;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RichId\ExcelGeneratorBundle\Tests\Resources\TestCase\ListenerTestCase;

/**
 * Class HeaderGenerationOnRowPreGeneratedTest.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Event\ExcelCellGeneratedEvent
 * @covers \RichId\ExcelGeneratorBundle\Listener\HeaderGenerationOnRowPreGenerated
 */
final class HeaderGenerationOnRowPreGeneratedTest extends ListenerTestCase
{
    public function testHeaderAddedWithStyle(): void
    {
        $spreadsheet = $this->generate();
        $sheet = $spreadsheet->getAllSheets()[0] ?? null;
        self::assertInstanceOf(Worksheet::class, $sheet);

        $cell = $sheet->getCell('H1');
        self::assertTrue($cell->getStyle()->getFont()->getBold());
        self::assertSame('FFFFFF', $cell->getStyle()->getFont()->getColor()->getRGB());
    }
}
