<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\ConfigurationExtractor;

use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class CellConfigurationsExtractor.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class CellConfigurationsExtractor
{
    /** @return CellConfiguration[] */
    public function getCellConfigurations(ExcelContent $excelContent): array
    {
        $reflectionClass = new \ReflectionClass($excelContent);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);
        $cellConfigurations = [];

        foreach ($properties as $property) {
            if (\in_array($property->getName(), ['parent', 'children'], true)) {
                continue;
            }

            $cellConfigurations[] = new CellConfiguration($property, $excelContent);
        }

        return $cellConfigurations;
    }
}
