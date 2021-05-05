<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Exception;

use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class InvalidExcelSpreadsheetException
 *
 * @package    RichId\ExcelGeneratorBundle\Exception
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class InvalidExcelSpreadsheetException extends \InvalidArgumentException implements ExcelExportException
{
    /** @var ExcelSpreadsheet */
    protected $excelSpreadsheet;

    /** @var ConstraintViolationListInterface */
    protected $violations;

    public function __construct(ExcelSpreadsheet $excelSpreadsheet, ConstraintViolationListInterface $violations)
    {
        $this->excelSpreadsheet = $excelSpreadsheet;
        $this->violations = $violations;

        parent::__construct('Invalid excel spreadsheet.');
    }
}