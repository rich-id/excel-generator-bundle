<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExcelContent.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExcelContent extends AbstractExcelNode
{
    /**
     * @var AbstractExcelNode
     *
     * @Assert\NotNull()
     * @Assert\Type("RichId\ExcelGeneratorBundle\Model\AbstractExcelNode")
     */
    public $parent;
}
