<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Twig;

use Contao\StringUtil;
use Override;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use function array_unique;
use function array_unshift;
use function array_values;
use function assert;
use function implode;
use function is_string;
use function str_starts_with;

final class TwigExtension extends AbstractExtension
{
    /** {@inheritDoc} */
    #[Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'contao_bootstrap_extract_btn_classes',
                [$this, 'extractBtnClasses'],
                ['needs_context' => true],
            ),
            new TwigFunction(
                'contao_bootstrap_extract_img_classes',
                [$this, 'extractImgClasses'],
                ['needs_context' => true],
            ),
            new TwigFunction(
                'contao_bootstrap_extract_table_classes',
                [$this, 'extractTableClasses'],
                ['needs_context' => true],
            ),
        ];
    }

    /**
     * @param array<string,mixed> $context
     *
     * @return list<string>
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function extractBtnClasses(array &$context): array
    {
        $cssClasses = StringUtil::trimsplit(' ', $context['element_css_classes'] ?? '');
        $btnClasses = [];

        foreach ($cssClasses as $index => $cssClass) {
            assert(is_string($cssClass));

            if (str_starts_with($cssClass, 'btn-')) {
                $btnClasses[] = $cssClass;
                unset($cssClasses[$index]);
            } elseif ($cssClass === 'btn') {
                $btnClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }
        }

        if ($btnClasses === []) {
            return [];
        }

        array_unshift($btnClasses, 'btn');

        $context['element_css_classes'] = implode(' ', $cssClasses);

        return array_values(array_unique($btnClasses));
    }

    /**
     * @param array<string,mixed> $context
     *
     * @return list<string>
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function extractImgClasses(array &$context): array
    {
        $cssClasses = StringUtil::trimsplit(' ', $context['element_css_classes'] ?? '');
        $imgClasses = [];

        foreach ($cssClasses as $index => $cssClass) {
            assert(is_string($cssClass));

            if (! str_starts_with($cssClass, 'img-')) {
                continue;
            }

            $imgClasses[] = $cssClass;
            unset($cssClasses[$index]);
        }

        if ($imgClasses === []) {
            return [];
        }

        $context['element_css_classes'] = implode(' ', $cssClasses);

        return array_values(array_unique($imgClasses));
    }

    /**
     * @param array<string,mixed> $context
     *
     * @return list<string>
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function extractTableClasses(array &$context): array
    {
        $cssClasses   = StringUtil::trimsplit(' ', $context['element_css_classes'] ?? '');
        $tableClasses = [];

        foreach ($cssClasses as $index => $cssClass) {
            assert(is_string($cssClass));

            if (! str_starts_with($cssClass, 'table-')) {
                continue;
            }

            $tableClasses[] = $cssClass;
            unset($cssClasses[$index]);
        }

        if ($tableClasses === []) {
            return [];
        }

        $context['element_css_classes'] = implode(' ', $cssClasses);

        return array_values(array_unique($tableClasses));
    }
}
