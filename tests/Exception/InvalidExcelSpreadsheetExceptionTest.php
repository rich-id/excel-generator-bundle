<?php declare(strict_types=1);

namespace Exception;

use RichCongress\TestSuite\TestCase\TestCase;
use RichId\ExcelGeneratorBundle\Exception\InvalidExcelSpreadsheetException;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class InvalidExcelSpreadsheetExceptionTest
 *
 * @package    Exception
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Exception\InvalidExcelSpreadsheetException
 */
final class InvalidExcelSpreadsheetExceptionTest extends TestCase
{
    public function testConstructorAndGetter(): void
    {
        $spreadsheet = new ExcelSpreadsheet();
        $violations = (new ValidatorBuilder())->getValidator()->validate($spreadsheet);
        $exception = new InvalidExcelSpreadsheetException($spreadsheet, $violations);

        self::assertSame($spreadsheet, $exception->getExcelSpreadsheet());
        self::assertSame($violations, $exception->getViolations());
    }
}
