<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Generator;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilderInterface;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;

/**
 * Class ExcelGenerator.
 *
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ExcelGenerator implements ExcelGeneratorInterface
{
    /** @var SpreadsheetBuilderInterface */
    protected $spreadsheetBuilder;

    public function __construct(SpreadsheetBuilderInterface $spreadsheetBuilder)
    {
        $this->spreadsheetBuilder = $spreadsheetBuilder;
    }

    public function save(ExcelSpreadsheet $excelSpreadsheet, string $path): void
    {
        $spreadsheet = ($this->spreadsheetBuilder)($excelSpreadsheet);
        $fullPath = \sprintf('%s/%s', $path, $excelSpreadsheet->filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($fullPath);
    }
}
