<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExcelSheet
 *
 * @package    RichId\ExcelGeneratorBundle\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelSheet extends AbstractExcelChild
{
    /**
     * @var ExcelSpreadsheet
     *
     * @Assert\NotNull()
     * @Assert\Type("RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet")
     */
    public $parent;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public $name;
}