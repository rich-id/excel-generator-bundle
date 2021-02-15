<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Interface SpreadsheetBuilderInterface
 *
 * @package   RichId\ExcelGeneratorBundle\Builder
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
interface SpreadsheetBuilderInterface
{
    public function buildSpreadsheet(array $sheets): Spreadsheet;
}
