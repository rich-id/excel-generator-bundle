<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Generator;

use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Interface ExcelGeneratorInterface
 *
 * @package   RichId\ExcelGeneratorBundle\Generator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
interface ExcelGeneratorInterface
{
    public function save(array $sheets, string $filename, string $path): void;

    public function generateResponse(array $sheets, string $filename): StreamedResponse;
}
