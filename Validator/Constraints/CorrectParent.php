<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class CorrectParent
 *
 * @package    RichId\ExcelGeneratorBundle\Validator\Constraints
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @Annotation
 */
class CorrectParent extends Constraint
{
    /** @var string */
    public $inappropriateParent = 'The parent is not what is expected, make sure you don\'t use an object twice and don\'t set the parent on your own.';
}
