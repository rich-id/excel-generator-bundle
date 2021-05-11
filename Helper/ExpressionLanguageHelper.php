<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Helper;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ExpressionLanguageHelper
 *
 * @package    RichId\ExcelGeneratorBundle\Helper
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class ExpressionLanguageHelper extends AbstractHelper
{
    /** @var ExpressionLanguage|null */
    private static $expressionLanguage;

    /**
     * @return mixed
     */
    public static function evaluate(string $expression, $data = null)
    {
        if ($data === null || \strpos($expression, 'this.') === false) {
            return $expression;
        }

        try {
            return static::getExpressionLanguage()->evaluate($expression, ['this' => $data]);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected static function getExpressionLanguage(): ExpressionLanguage
    {
        if (self::$expressionLanguage === null) {
            self::$expressionLanguage = new ExpressionLanguage();
        }

        return self::$expressionLanguage;
    }
}
