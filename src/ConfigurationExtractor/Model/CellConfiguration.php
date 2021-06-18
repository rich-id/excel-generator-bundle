<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model;

use RichId\ExcelGeneratorBundle\Annotation\ColumnMerge;
use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Helper\AnnotationHelper;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class CellConfiguration.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class CellConfiguration
{
    /** @var \ReflectionProperty */
    public $reflectionProperty;

    /** @var ExcelContent */
    public $model;

    /** @var ContentStyle|null */
    public $style;

    /** @var ColumnMerge */
    public $columnMerge;

    public function __construct(\ReflectionProperty $reflectionProperty, ExcelContent $model)
    {
        $this->reflectionProperty = $reflectionProperty;
        $this->model = $model;
        $this->style = $this->getAnnotation(ContentStyle::class);
        $this->columnMerge = $this->getAnnotation(ColumnMerge::class);
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->reflectionProperty->getValue($this->model);
    }

    /** @return mixed|object|null */
    public function getAnnotation(string $annotationClass)
    {
        return AnnotationHelper::getPropertyAnnotation($this->reflectionProperty, $annotationClass);
    }
}
