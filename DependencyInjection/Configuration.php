<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_excel_generator';

    protected function buildConfiguration(ArrayNodeDefinition $rootNode): void
    {
        $children = $rootNode->children();
        $this->buildConfig($children);
        $children->end();
    }

    protected function buildConfig(NodeBuilder $nodeBuilder): void
    {
        // Do something
    }
}
