<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Listener;

use RichId\ExcelGeneratorBundle\Annotation\ColumnMerge;
use RichId\ExcelGeneratorBundle\Annotation\HeaderStyle;
use RichId\ExcelGeneratorBundle\Annotation\HeaderTitle;
use RichId\ExcelGeneratorBundle\Builder\Partials\SheetRowContentBuilder;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\CellConfigurationsExtractor;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\CellConfiguration;
use RichId\ExcelGeneratorBundle\ConfigurationExtractor\Model\GeneratedCellConfiguration;
use RichId\ExcelGeneratorBundle\Event\ExcelRowPreGeneratedEvent;
use RichId\ExcelGeneratorBundle\Helper\AnnotationHelper;
use RichId\ExcelGeneratorBundle\Helper\WorksheetHelper;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HeaderGenerationOnRowPreGenerated
 *
 * @package    RichId\ExcelGeneratorBundle\Listener
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
class HeaderGenerationOnRowPreGenerated
{
    /** @var CellConfigurationsExtractor */
    protected $cellConfigurationsExtractor;

    /** @var SheetRowContentBuilder */
    protected $sheetRowContentBuilder;

    /** @var TranslatorInterface */
    protected $translator;

    public function __construct(CellConfigurationsExtractor $configurationExtractor, TranslatorInterface $translator)
    {
        $this->cellConfigurationsExtractor = $configurationExtractor;
        $this->translator = $translator;
    }

    public function __invoke(ExcelRowPreGeneratedEvent $event): void
    {
        $cellConfigurations = ($this->cellConfigurationsExtractor)($event->model);
        $row = (int) $event->worksheet->getHighestRow();

        if (!$this->hasHeader($cellConfigurations)) {
            return;
        }

        foreach ($cellConfigurations as $index => $cellConfiguration) {
            $newConfiguration = $this->generateCellConfiguration($event, $cellConfiguration);
            $this->sheetRowContentBuilder->buildFromCellConfiguration(
                $event->worksheet,
                $newConfiguration,
                $index + 1,
                $row
            );
        }

        WorksheetHelper::newLine($event->worksheet);
    }

    /**
     * @param CellConfiguration[] $cellConfigurations
     */
    protected function hasHeader(array $cellConfigurations): bool
    {
        foreach ($cellConfigurations as $cellConfiguration) {
            if ($cellConfiguration->getAnnotation(HeaderTitle::class) !== null) {
                return true;
            }
        }

        return false;
    }

    protected function generateCellConfiguration(ExcelRowPreGeneratedEvent $event, CellConfiguration $cellConfiguration): GeneratedCellConfiguration
    {
        $generatedCell = new GeneratedCellConfiguration($cellConfiguration->reflectionProperty, $cellConfiguration->model);
        $generatedCell->style = AnnotationHelper::getClassAnnotation($event->model, HeaderStyle::class);
        $generatedCell->value = '';
        $title = $cellConfiguration->getAnnotation(HeaderTitle::class);

        if (!$title instanceof HeaderTitle) {
            return $generatedCell;
        }

        $generatedCell->value = $this->resolveTitle($title);

        if ($title->columnMerge !== null) {
            $generatedCell->columnMerge = new ColumnMerge();
            $generatedCell->columnMerge->count = $title->columnMerge;
        }

        if ($title->hasStyle()) {
            $generatedCell->style = $title;
        }

        return $generatedCell;
    }

    protected function resolveTitle(HeaderTitle $headerTitle): string
    {
        if ($headerTitle->translationKey !== null) {
            return $this->translator->trans($headerTitle->translationKey);
        }

        return $headerTitle->title ?? '';
    }
}
