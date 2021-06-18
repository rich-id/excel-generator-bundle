<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Resources\Model;

use RichId\ExcelGeneratorBundle\Annotation\ContentStyle;
use RichId\ExcelGeneratorBundle\Annotation\HeaderTitle;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;

/**
 * Class DummyExcelContent.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class DummyExcelContent extends ExcelContent
{
    /** @var string */
    public $property1 = 'First property';

    /** @var int */
    public $property2 = 2;

    /** @var bool */
    public $property3 = true;

    /**
     * @var string
     *
     * @ContentStyle(bold=true)
     */
    public $boldString = 'Bold';

    /**
     * @var string
     *
     * @ContentStyle(color="this.getColor()", backgroundColor="this.getBackgroundColor()")
     */
    public $coloredFromExpression = 'Colored from expression';

    /**
     * @var string
     *
     * @ContentStyle(color="#EEEEEE", backgroundColor="000000")
     */
    public $coloredFromHexadecimal = 'Colored from hexadecimal';

    /**
     * @var string
     *
     * @ContentStyle(fontSize=34)
     */
    public $bigFontSize = 'Big font size';

    /**
     * @var string
     *
     * @HeaderTitle(title="A great title!", color="FFFFFF", backgroundColor="000000", bold=true, columnMerge=2)
     */
    public $withHeader = 'With header';

    public function getColor(): string
    {
        return '#FFFFFF';
    }

    public function getBackgroundColor(): string
    {
        return '#111111';
    }
}
