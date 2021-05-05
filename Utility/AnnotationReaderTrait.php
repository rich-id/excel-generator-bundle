<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Utility;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Trait AnnotationReaderTrait
 *
 * @package   RichId\ExcelGeneratorBundle\Utility
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
trait AnnotationReaderTrait
{
    /** @var AnnotationReader */
    private $annotationReader;

    protected function getClassAnnotationFor(string $class, string $annotation)
    {
        return $this->getAnnotationReader()->getClassAnnotation(new \ReflectionClass($class), $annotation);
    }

    protected function getPropertyAnnotationForProperty(\ReflectionProperty $property, string $annotation)
    {
        return $this->getAnnotationReader()->getPropertyAnnotation($property, $annotation);
    }

    private function getAnnotationReader(): AnnotationReader
    {
        if ($this->annotationReader === null) {
            $this->annotationReader = new AnnotationReader();
        }

        return $this->annotationReader;
    }
}
