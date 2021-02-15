<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Utility;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;
use RichId\ExcelGeneratorBundle\Data\Export;
use RichId\ExcelGeneratorBundle\Data\Property;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class PropertyUtility
 *
 * @package   RichId\ExcelGeneratorBundle\Utility
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class PropertyUtility
{
    /** @var NormalizerInterface */
    protected $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function getPropertiesForConfig(ExcelSheetGeneratorConfiguration $configuration): array
    {
        $class = new \ReflectionClass($configuration->getClass());

        /** @var Export $object */
        $object = $class->newInstanceWithoutConstructor();

        return $this->getPropertiesForConfigAndData($configuration, $object);
    }

    public function getPropertiesForConfigAndData(ExcelSheetGeneratorConfiguration $configuration, Export $rowContent): array
    {
        $properties = [];
        $reflectionClass = new \ReflectionClass($configuration->getClass());

        $normalizedObject = $this->getNormalizedDataForExportData($configuration, $rowContent);
        $propertiesName = \array_keys($normalizedObject);

        foreach ($reflectionClass->getProperties() as $objectProperty) {
            if (!\in_array($objectProperty->getName(), $propertiesName, true)) {
                continue;
            }

            $properties[] = Property::build($objectProperty->getName(), $objectProperty, $normalizedObject[$objectProperty->getName()]);
        }

        return $properties;
    }

    private function getNormalizedDataForExportData(ExcelSheetGeneratorConfiguration $configuration, Export $rowContent): array
    {
        $context = empty($configuration->getSerializationGroups()) ? [] : [AbstractNormalizer::GROUPS => $configuration->getSerializationGroups()];
        $context[AbstractNormalizer::IGNORED_ATTRIBUTES ] = ['childConfiguration'];

        return $this->normalizer->normalize($rowContent, null, $context);
    }
}
