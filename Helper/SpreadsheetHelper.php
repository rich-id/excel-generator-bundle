<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Helper;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class SpreadsheetHelper
 *
 * @package    RichId\ExcelGeneratorBundle\Helper
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
final class SpreadsheetHelper extends AbstractHelper
{
    public static function getOrCreateWorksheet(Spreadsheet $spreadsheet, int $index): Worksheet
    {
        return $index < $spreadsheet->getSheetCount()
            ? $spreadsheet->getSheet($index)
            : $spreadsheet->createSheet($index);
    }
}
