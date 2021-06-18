<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Helper;

/**
 * Class ArrayHelper.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
final class ArrayHelper extends AbstractHelper
{
    public static function mergeOptions(array $base, array $data): array
    {
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $base[$key] = self::mergeOptions($base[$key] ?? [], $value);
            } else {
                $base[$key] = $value;
            }
        }

        return $base;
    }
}
