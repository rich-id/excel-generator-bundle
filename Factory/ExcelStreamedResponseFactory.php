<?php declare(strict_types=1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ExcelStreamedResponseFactory
 *
 * @author    Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright 2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelStreamedResponseFactory
{
    /** @var SpreadsheetBuilderInterface */
    protected $spreadsheetBuilder;

    public function __construct(SpreadsheetBuilderInterface $spreadsheetBuilder)
    {
        $this->spreadsheetBuilder = $spreadsheetBuilder;
    }

    public function __invoke(array $sheets, string $filename): StreamedResponse
    {
        $streamedResponse = new StreamedResponse();
        $writer = self::generateWriter($this->spreadsheetBuilder->buildSpreadsheet($sheets));

        $streamedResponse->setCallback(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );

        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set('Content-Type', 'application/vnd.ms-excel');
        $streamedResponse->headers->set('Content-Disposition', \sprintf('attachment; filename="%s"', $filename));

        return $streamedResponse->send();
    }

    private static function generateWriter(Spreadsheet $spreadsheet): Xlsx
    {
        return new Xlsx($spreadsheet);
    }
}