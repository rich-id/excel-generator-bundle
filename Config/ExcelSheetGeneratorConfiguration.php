<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Config;

use RichId\ExcelGeneratorBundle\Data\Export;
use RichId\ExcelGeneratorBundle\Exception\NotSameClassException;
use RichId\ExcelGeneratorBundle\Exception\NotSupportedExportDataException;

/**
 * Class ExcelSheetGeneratorConfiguration
 *
 * @package   RichId\ExcelGeneratorBundle\Config
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class ExcelSheetGeneratorConfiguration
{
    /** @var string */
    protected $class;

    /** @var array */
    protected $rowsContent;

    /** @var array */
    protected $serializationGroups;

    /** @var bool bool */
    protected $withoutHeader = false;

    private function __construct()
    {
    }

    public static function create(string $class, array $rowsContent, array $serializationGroups = []): ExcelSheetGeneratorConfiguration
    {
        self::assertClassSubclassOfExport($class);
        self::assertRowsContentSameClassAs($class, $rowsContent);

        $config = new self();

        $config->class = $class;
        $config->rowsContent = $rowsContent;
        $config->serializationGroups = $serializationGroups;

        return $config;
    }

    // Actions

    public function withoutHeader(): self
    {
        $this->withoutHeader = true;

        return $this;
    }

    // Getters

    public function getClass(): string
    {
        return $this->class;
    }

    public function getRowsContent(): array
    {
        return $this->rowsContent;
    }

    public function getSerializationGroups(): array
    {
        return $this->serializationGroups;
    }

    public function isWithoutHeader(): bool
    {
        return $this->withoutHeader;
    }

    private static function assertClassSubclassOfExport(string $objectClass): void
    {
        $reflectionClass = new \ReflectionClass($objectClass);

        if (!$reflectionClass->isSubclassOf(Export::class)) {
            throw new NotSupportedExportDataException($objectClass);
        }
    }

    private static function assertRowsContentSameClassAs(string $objectClass, array $rowsContent): void
    {
        foreach ($rowsContent as $rowContent) {
            $rowContentClass = \get_class($rowContent);

            if ($rowContentClass !== $objectClass) {
                throw new NotSameClassException($rowContentClass, $objectClass);
            }
        }
    }
}
