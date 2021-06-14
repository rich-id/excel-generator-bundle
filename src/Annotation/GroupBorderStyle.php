<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Annotation;

/**
 * Class GroupBorderStyle.
 *
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"CLASS"})
 */
final class GroupBorderStyle
{
    public const BORDER_OUTLINE = 'outline';

    /** @var string */
    public $border;

    public function hasAllowedBorder(): bool
    {
        return $this->border !== null && \in_array($this->border, [self::BORDER_OUTLINE], true);
    }
}
