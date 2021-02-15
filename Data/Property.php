<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Data;

/**
 * Class Property
 *
 * @package   RichId\ExcelGeneratorBundle\Data
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class Property
{
    /** @var string */
    protected $name;

    /** @var \ReflectionProperty */
    protected $reflectionProperty;

    /** @var mixed */
    protected $value;

    private function __construct()
    {
    }

    public static function build(string $name, \ReflectionProperty $property, $value): self
    {
        $object = new self();

        $object->name = $name;
        $object->reflectionProperty = $property;
        $object->value = $value;

        return $object;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReflectionProperty(): \ReflectionProperty
    {
        return $this->reflectionProperty;
    }

    public function getValue()
    {
        return $this->value;
    }
}
