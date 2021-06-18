<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Helper;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class AnnotationHelper.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class AnnotationHelper extends AbstractHelper
{
    /** @var AnnotationReader */
    private static $annotationReader;

    public static function getAnnotationReader(): AnnotationReader
    {
        if (static::$annotationReader === null) {
            static::$annotationReader = new AnnotationReader();
        }

        return static::$annotationReader;
    }

    /** @param \ReflectionClass|string|object $class */
    public static function getClassAnnotation($class, string $annotation)
    {
        if ($class === null) {
            return null;
        }

        $reflectionClass = $class instanceof \ReflectionClass ? $class : new \ReflectionClass($class);

        return static::getAnnotationReader()->getClassAnnotation($reflectionClass, $annotation);
    }

    public static function getPropertyAnnotation(\ReflectionProperty $property, string $annotation)
    {
        return static::getAnnotationReader()->getPropertyAnnotation($property, $annotation);
    }
}
