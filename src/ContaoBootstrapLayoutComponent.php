<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout;

use ContaoBootstrap\Core\ContaoBootstrapComponent;
use RuntimeException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ContaoBootstrapLayoutComponent implements ContaoBootstrapComponent
{
    public function addBootstrapConfiguration(ArrayNodeDefinition $builder): void
    {
        try {
            $layout = $builder->find('layout');
        } catch (RuntimeException $exception) {
            $layout = $builder->children()->arrayNode('layout');
        }

        $layout
            ->children()
                ->scalarNode('viewport')
                    ->defaultValue('width=device-width, initial-scale=1, shrink-to-fit=no')
                ->end()
                ->arrayNode('contao_framework_css')
                    ->info('Disable or enable contao framework css files')
                    ->booleanPrototype()->end()
                ->end()
                ->arrayNode('replace_css_classes')
                    ->info('Map of classes to be replaced')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('filters')
                    ->info('Output filte configuration')
                    ->children()
                        ->arrayNode('replace_css_classes_templates')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('replace_images_classes_templates')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('replace_table_classes_templates')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
