<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Model;

use RichId\ExcelGeneratorBundle\Validator\Constraints as ExcelConstraints;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExcelSpreadsheet.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelSpreadsheet
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public $filename;

    /**
     * @var ExcelSheet[]
     *
     * @Assert\Valid()
     * @Assert\All({
     *     @Assert\Type("RichId\ExcelGeneratorBundle\Model\ExcelSheet"),
     *     @ExcelConstraints\CorrectParent()
     * })
     */
    private $sheets = [];

    public function addSheet(ExcelSheet $excelSheet): self
    {
        $this->sheets[] = $excelSheet;
        $excelSheet->parent = $this;

        return $this;
    }

    /** @return ExcelSheet[] */
    public function getSheets(): array
    {
        return $this->sheets;
    }
}
