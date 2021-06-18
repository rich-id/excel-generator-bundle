<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Factory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilderInterface;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ExcelStreamedResponseFactory.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelStreamedResponseFactory
{
    /** @var SpreadsheetBuilderInterface */
    protected $spreadsheetBuilder;

    public function __construct(SpreadsheetBuilderInterface $spreadsheetBuilder)
    {
        $this->spreadsheetBuilder = $spreadsheetBuilder;
    }

    public function __invoke(ExcelSpreadsheet $spreadsheet): StreamedResponse
    {
        $streamedResponse = new StreamedResponse();
        $excel = ($this->spreadsheetBuilder)($spreadsheet);
        $writer = self::generateWriter($excel);

        $streamedResponse->setCallback(
            static function () use ($writer): void {
                $writer->save('php://output');
            }
        );

        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set('Content-Type', 'application/vnd.ms-excel');
        $streamedResponse->headers->set('Content-Disposition', \sprintf('attachment; filename="%s"', $spreadsheet->filename));

        return $streamedResponse->send();
    }

    private static function generateWriter(Spreadsheet $spreadsheet): Xlsx
    {
        return new Xlsx($spreadsheet);
    }
}
