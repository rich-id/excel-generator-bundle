<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Annotation;

/**
 * Class BorderStyle
 *
 * @package   RichId\ExcelGeneratorBundle\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
abstract class BorderStyle
{
    public const BORDER_BOTTOM = 'bottom';
    public const BORDER_LEFT = 'left';
    public const BORDER_RIGHT = 'right';
    public const BORDER_TOP = 'top';

    public const BORDER_ALL_BORDERS = 'allBorders';
    public const BORDER_DIAGONAL = 'diagonal';
    public const BORDER_HORIZONTAL = 'horizontal';
    public const BORDER_INSIDE = 'inside';
    public const BORDER_OUTLINE = 'outline';
    public const BORDER_VERTICAL = 'vertical';

    public const BORDER_DASHDOT = 'dashDot';
    public const BORDER_DASHDOTDOT = 'dashDotDot';
    public const BORDER_DASHED = 'dashed';
    public const BORDER_DOTTED = 'dotted';
    public const BORDER_DOUBLE = 'double';
    public const BORDER_HAIR = 'hair';
    public const BORDER_MEDIUM = 'medium';
    public const BORDER_MEDIUMDASHDOT = 'mediumDashDot';
    public const BORDER_MEDIUMDASHDOTDOT = 'mediumDashDotDot';
    public const BORDER_MEDIUMDASHED = 'mediumDashed';
    public const BORDER_SLANTDASHDOT = 'slantDashDot';
    public const BORDER_THICK = 'thick';
    public const BORDER_THIN = 'thin';

    /** @var string[] */
    public $border;

    /** @var string */
    public $borderStyle = self::BORDER_HAIR;

    /** @var string */
    public $borderColor = '000000';

    public function hasAllowedBorder(): bool
    {
        if ($this->border === null || empty($this->border)) {
            return false;
        }

        foreach ($this->border as $border) {
            if (!\in_array(
                $border,
                [
                    self::BORDER_BOTTOM,
                    self::BORDER_LEFT,
                    self::BORDER_RIGHT,
                    self::BORDER_TOP,
                    self::BORDER_ALL_BORDERS,
                    self::BORDER_DIAGONAL,
                    self::BORDER_HORIZONTAL,
                    self::BORDER_INSIDE,
                    self::BORDER_OUTLINE,
                    self::BORDER_VERTICAL,
                ],
                true
            )) {
                return false;
            }
        }

        return true;
    }

    public function hasAllowedBorderStyle(): bool
    {
        return $this->borderStyle != null && \in_array(
                $this->borderStyle,
                [
                    self::BORDER_DASHDOT,
                    self::BORDER_DASHDOTDOT,
                    self::BORDER_DASHED,
                    self::BORDER_DOTTED,
                    self::BORDER_DOUBLE,
                    self::BORDER_HAIR,
                    self::BORDER_MEDIUM,
                    self::BORDER_MEDIUMDASHDOT,
                    self::BORDER_MEDIUMDASHDOTDOT,
                    self::BORDER_MEDIUMDASHED,
                    self::BORDER_SLANTDASHDOT,
                    self::BORDER_THICK,
                    self::BORDER_THIN,
                ],
                true
            );
    }
}
