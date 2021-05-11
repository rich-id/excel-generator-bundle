<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Model;

use RichId\ExcelGeneratorBundle\Validator\Constraints as ExcelConstraints;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractExcelChild
 *
 * @package    RichId\ExcelGeneratorBundle\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
abstract class AbstractExcelChild
{
    /**
     * @var ExcelContent[]
     *
     * @Assert\Valid()
     * @Assert\All({
     *     @Assert\Type("RichId\ExcelGeneratorBundle\Model\ExcelContent"),
     *     @ExcelConstraints\CorrectParent()
     * })
     */
    private $children = [];

    public function addChild(ExcelContent $excelContent): self
    {
        $this->children[] = $excelContent;
        $excelContent->parent = $this;

        return $this;
    }

    /**
     * @return ExcelContent[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
