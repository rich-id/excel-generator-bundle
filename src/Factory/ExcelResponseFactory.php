<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Factory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilderInterface;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExcelResponseFactory.
 *
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ExcelResponseFactory
{
    /** @var SpreadsheetBuilderInterface */
    protected $spreadsheetBuilder;

    public function __construct(SpreadsheetBuilderInterface $spreadsheetBuilder)
    {
        $this->spreadsheetBuilder = $spreadsheetBuilder;
    }

    public function __invoke(ExcelSpreadsheet $spreadsheet): Response
    {
        $response = new Response();
        $excel = ($this->spreadsheetBuilder)($spreadsheet);
        $writer = self::generateWriter($excel);

        $fs = new Filesystem();
        $filename = $fs->tempnam(\sys_get_temp_dir(), '');

        $writer->save($filename);

        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', \sprintf('attachment; filename="%s"', $spreadsheet->filename));
        $response->setContent(\file_get_contents($filename));

        $fs->remove($filename);

        return $response;
    }

    private static function generateWriter(Spreadsheet $spreadsheet): Xlsx
    {
        return new Xlsx($spreadsheet);
    }
}
