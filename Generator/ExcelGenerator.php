<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Generator;

use RichId\ExcelGeneratorBundle\Builder\SpreadsheetBuilderInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ExcelGenerator
 *
 * @package   RichId\ExcelGeneratorBundle\Generator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class ExcelGenerator implements ExcelGeneratorInterface
{
    /** @var SpreadsheetBuilderInterface */
    protected $spreadsheetBuilder;

    public function __construct(SpreadsheetBuilderInterface $spreadsheetBuilder)
    {
        $this->spreadsheetBuilder = $spreadsheetBuilder;
    }

    public function save(array $sheets, string $filename, string $path): void
    {
        $writer = self::generateWriter($this->spreadsheetBuilder->buildSpreadsheet($sheets));
        $writer->save(\sprintf('%s/%s', $path, $filename));
    }

    public function generateResponse(array $sheets, string $filename): StreamedResponse
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

    private function generateWriter(Spreadsheet $spreadsheet)
    {
        return new Xlsx($spreadsheet);
    }
}
