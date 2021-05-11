<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Validator\Constraints;

use RichId\ExcelGeneratorBundle\Model\AbstractExcelChild;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class CorrectParentValidator
 *
 * @package    RichId\ExcelGeneratorBundle\Validator\Constraints
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class CorrectParentValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof AbstractExcelChild || !$constraint instanceof CorrectParent) {
            return;
        }

        $subject =  $this->context->getObject();

        if ($value->parent !== null && $subject !== $value->parent) {
            $this->context->addViolation($constraint->inappropriateParent);
        }
    }
}
