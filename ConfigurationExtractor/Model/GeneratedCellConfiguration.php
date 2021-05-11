<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model;

/**
 * Class GeneratedCellConfiguration
 *
 * @package    RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * Use to dynamically insert a row
 */
class GeneratedCellConfiguration extends CellConfiguration
{
    /** @var mixed */
    public $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
