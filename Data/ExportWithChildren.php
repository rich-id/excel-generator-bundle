<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Data;

use RichId\ExcelGeneratorBundle\Config\ExcelSheetGeneratorConfiguration;

/**
 * Interface ExportWithChild
 *
 * @package   RichId\ExcelGeneratorBundle\Data
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
abstract class ExportWithChildren implements Export
{
    /** @var ExcelSheetGeneratorConfiguration */
    protected $childConfiguration;

    public function getChildConfiguration(): ExcelSheetGeneratorConfiguration
    {
        return $this->childConfiguration;
    }
}
