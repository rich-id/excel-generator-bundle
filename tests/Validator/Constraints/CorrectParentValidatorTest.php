<?php declare(strict_types=1);

namespace Validator\Constraints;

use RichCongress\TestSuite\TestCase\TestCase;
use RichCongress\TestTools\Stubs\Symfony\ValidationContextStub;
use RichId\ExcelGeneratorBundle\Model\ExcelContent;
use RichId\ExcelGeneratorBundle\Model\ExcelSheet;
use RichId\ExcelGeneratorBundle\Model\ExcelSpreadsheet;
use RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParent;
use RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParentValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class CorrectParentValidatorTest
 *
 * @package    Validator\Constraints
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @covers \RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParent
 * @covers \RichId\ExcelGeneratorBundle\Validator\Constraints\CorrectParentValidator
 */
final class CorrectParentValidatorTest extends TestCase
{
    /** @var ValidationContextStub */
    private $context;

    /** @var CorrectParentValidator */
    private $validator;

    public function beforeTest(): void
    {
        $this->context = new ValidationContextStub();
        $this->validator = new CorrectParentValidator();
        $this->validator->initialize($this->context);
    }

    public function testValidatorNotExcelNode(): void
    {
        $model = new ExcelSpreadsheet();
        $this->validator->validate($model, new CorrectParent());

        self::assertEmpty($this->context->getViolations());
    }

    public function testValidatorIncorrectConstraint(): void
    {
        $model = new ExcelSheet();
        $this->validator->validate($model, new NotNull());

        self::assertEmpty($this->context->getViolations());
    }

    public function testValidatorCorrectParent(): void
    {
        $parent = new ExcelSheet();
        $child = new ExcelContent();
        $child->parent = $parent;

        $this->validator->validate($parent, new CorrectParent());

        self::assertEmpty($this->context->getViolations());
    }

    public function testValidatorIncorrectParent(): void
    {
        $parent = new ExcelSheet();
        $child = new ExcelContent();
        $child->parent = new ExcelSheet();

        $this->validator->validate($parent, new CorrectParent());

        self::assertEmpty($this->context->getViolations());
    }
}
