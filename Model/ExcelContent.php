<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExcelContent
 *
 * @package    RichId\ExcelGeneratorBundle\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
abstract class ExcelContent extends AbstractExcelChild
{
    /**
     * @var AbstractExcelChild
     *
     * @Assert\NotNull()
     * @Assert\Type("RichId\ExcelGeneratorBundle\Model\AbstractExcelChild")
     */
    public $parent;
}