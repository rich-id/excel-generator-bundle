<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Helper;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class WorksheetHelper
 *
 * @package    RichId\ExcelGeneratorBundle\Helper
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
final class WorksheetHelper extends AbstractHelper
{
    public static function newLine(Worksheet $worksheet): void
    {
        $worksheet->setCellValueByColumnAndRow(1, $worksheet->getHighestRow() + 1, '');
    }
}
