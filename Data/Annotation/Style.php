<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Data\Annotation;

/**
 * Class Style
 *
 * @package   RichId\ExcelGeneratorBundle\Data\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
abstract class Style extends BorderStyle
{
    public const POSITION_LEFT = 'left';
    public const POSITION_CENTER = 'center';
    public const POSITION_RIGHT = 'right';

    public const VERTICAL_POSITION_TOP = 'top';
    public const VERTICAL_POSITION_CENTER = 'center';
    public const VERTICAL_POSITION_BOTTOM = 'bottom';

    public const BORDER_OUTLINE = 'outline';

    /** @var string */
    public $color;

    /** @var string */
    public $backgroundColor;

    /** @var int */
    public $fontSize;

    /** @var bool */
    public $bold;

    /** @var string */
    public $position;

    /** @var string */
    public $verticalPosition;

    /** @var bool */
    public $wrapText;

    public function hasStyle(): bool
    {
        return $this->color !== null || $this->backgroundColor !== null || $this->fontSize !== null || $this->bold !== null || $this->position !== null || $this->verticalPosition !== null || $this->border !== null || $this->wrapText !== null;
    }

    public function hasAllowedPosition(): bool
    {
        return $this->position != null && \in_array($this->position, [self::POSITION_LEFT, self::POSITION_CENTER, self::POSITION_RIGHT], true);
    }

    public function hasAllowedVerticalPosition(): bool
    {
        return $this->verticalPosition != null && \in_array($this->verticalPosition, [self::VERTICAL_POSITION_TOP, self::VERTICAL_POSITION_CENTER, self::VERTICAL_POSITION_BOTTOM], true);
    }
}
