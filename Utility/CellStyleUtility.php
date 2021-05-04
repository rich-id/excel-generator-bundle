<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Utility;

use PhpOffice\PhpSpreadsheet\Style\Border;
use RichId\ExcelGeneratorBundle\Data\Annotation\Style;
use RichId\ExcelGeneratorBundle\Data\Export;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class CellStyleUtility
 *
 * @package   RichId\ExcelGeneratorBundle\Utility
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class CellStyleUtility
{
    /** @var ExpressionLanguage */
    protected $expressionLanguage;

    public function __construct()
    {
        $this->expressionLanguage = new ExpressionLanguage();
    }

    public function setStyleFor(Worksheet $sheet, Style $style, int $row, int $from, ?int $to = null): void
    {
        $this->setStyleOfDataFor($sheet, $style, $row, $from, null, $to);
    }

    public function setStyleOfDataFor(Worksheet $sheet, Style $style, int $row, int $from, ?Export $data, ?int $to = null): void
    {
        $items = $to === null
            ? \sprintf('%s%d', Coordinate::stringFromColumnIndex($from), $row)
            : \sprintf('%s%d:%s%d', Coordinate::stringFromColumnIndex($from), $row, Coordinate::stringFromColumnIndex($to), $row);


        $sheet->getStyle($items)
            ->applyFromArray($this->buildStyleToApply($style, $data));
    }

    private function buildStyleToApply(Style $style, ?Export $data = null): array
    {
        $buildStyle = [];

        if ($style->bold !== null) {
            $buildStyle = ['font' => ['bold' => $style->bold]];
        }

        if ($style->color !== null) {
            $hexCode = $this->getStyleValueWithExpression($style->color, $data);

            if ($hexCode !== null) {
                $buildStyle['font']['color'] = ['rgb' => \str_replace('#', '', $hexCode)];
            }
        }

        if ($style->fontSize !== null) {
            $buildStyle['font']['size'] = $style->fontSize;
        }

        if ($style->backgroundColor !== null) {
            $hexCode = $this->getStyleValueWithExpression($style->backgroundColor, $data);

            if ($hexCode !== null) {
                $buildStyle['fill'] = [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => \str_replace('#', '', $hexCode)]
                ];
            }
        }

        if ($style->hasAllowedPosition()) {
            $buildStyle['alignment'] = [
                'horizontal' => $style->position
            ];
        }

        if ($style->hasAllowedVerticalPosition()) {
            if (!isset($buildStyle['alignment'])) {
                $buildStyle['alignment'] = [];
            }

            $buildStyle['alignment']['vertical'] = $style->verticalPosition;
        }

        if ($style->hasAllowedBorder()) {
            $borderStyle = $style->hasAllowedBorderStyle() ? $style->borderStyle : Border::BORDER_HAIR;
            $buildStyle['borders'] = [];

            foreach ($style->border as $border) {
                $buildStyle['borders'][$border] = [
                    'borderStyle' => $borderStyle,
                    'color'       => ['rgb' => $style->borderColor],
                ];
            }
        }

        if ($style->wrapText === true) {
            if (!isset($buildStyle['alignment'])) {
                $buildStyle['alignment'] = [];
            }

            $buildStyle['alignment']['wrapText'] = true;
        }

        return $buildStyle;
    }

    private function getStyleValueWithExpression(string $value, ?Export $data = null): ?string
    {
        if (\strpos($value, 'this.') !== false && $data !== null) {
            try {
                return $this->expressionLanguage->evaluate($value, ['this' => $data]);
            } catch (\Exception $e) {
                return '';
            }
        } else {
            return $value;
        }
    }
}
