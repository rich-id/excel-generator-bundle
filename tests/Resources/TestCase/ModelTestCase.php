<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Tests\Resources\TestCase;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ModelTestCase.
 *
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 *
 * @TestConfig("container")
 */
abstract class ModelTestCase extends TestCase
{
    /** @var object */
    protected $model;

    protected function validate(): ConstraintViolationListInterface
    {
        return $this->getService(ValidatorInterface::class)->validate($this->model);
    }
}
