<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Helper;

use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Netzmacht\Html\Attributes;

use function in_array;
use function sprintf;

/**
 * LayoutHelper is a template helper for the fe_bootstrap template.
 */
final class LayoutHelper
{
    public const LEFT      = 'left';
    public const RIGHT     = 'right';
    public const MAIN      = 'main';
    public const HEADER    = 'header';
    public const FOOTER    = 'footer';
    public const WRAPPER   = 'wrapper';
    public const CONTAINER = 'container';

    /**
     * Main css class.
     */
    private string $mainClass = '';

    /**
     * Left css class.
     */
    private string $leftClass = '';

    /**
     * Right css class.
     */
    private string $rightClass = '';

    /**
     * Use grid column system.
     */
    private bool $useGrid = false;

    /**
     * Page layout.
     */
    private LayoutModel $layout;

    /**
     * Construct.
     *
     * @param FrontendTemplate $template   Frontend page template.
     * @param LayoutModel      $pageLayout Layout model.
     */
    protected function __construct(private readonly FrontendTemplate $template, LayoutModel $pageLayout)
    {
        $this->layout = $pageLayout;

        $this->initialize();
    }

    /**
     * Instantiate helper for frontend page template.
     *
     * @param FrontendTemplate $template Frontend page template.
     *
     * @return static
     */
    public static function forTemplate(FrontendTemplate $template): self
    {
        return new self($template, $template->bootstrapEnvironment->layout);
    }

    /**
     * Check if page layout is a bootstrap layout.
     */
    public function isBootstrapLayout(): bool
    {
        return $this->layout->layoutType === 'bootstrap';
    }

    /**
     * Get attributes for a specific section.
     *
     * @param string $sectionId The section id.
     * @param bool   $inside    If true the inside class is added. Otherwhise $sectionId is set as id attribute.
     */
    public function getAttributes(string $sectionId, bool $inside = false): Attributes
    {
        $attributes = new Attributes();

        if ($inside) {
            $attributes->addClass('inside');
        } else {
            $attributes->setId($sectionId);
        }

        if (in_array($sectionId, [self::FOOTER, self::HEADER])) {
            $key = sprintf('bs_%sClass', $sectionId);

            if ($this->layout->$key) {
                $attributes->addClass($this->layout->$key);
            }
        } elseif (in_array($sectionId, [self::CONTAINER, self::WRAPPER])) {
            $class = $this->layout->bs_containerClass;

            if ($class && $this->layout->bs_containerElement === $sectionId) {
                $attributes->addClass($class);
            }
        } elseif ($this->isGridActive()) {
            $key = sprintf('%sClass', $sectionId);

            if (! empty($this->$key)) {
                $attributes->addClass($this->$key);
            }
        }

        $this->addSchemaAttributes($sectionId, $inside, $attributes);

        return $attributes;
    }

    /**
     * Check if grid is active.
     */
    public function isGridActive(): bool
    {
        return $this->layout->cols !== '1cl' && $this->layout->cols !== '';
    }

    /**
     * Initialize the helper.
     */
    private function initialize(): void
    {
        if (! $this->isBootstrapLayout()) {
            return;
        }

        switch ($this->layout->cols) {
            case '2cll':
                $this->leftClass = $this->layout->bs_leftClass;
                $this->mainClass = $this->layout->bs_mainClass;
                break;

            case '2clr':
                $this->rightClass = $this->layout->bs_rightClass;
                $this->mainClass  = $this->layout->bs_mainClass;
                break;

            case '3cl':
                $this->leftClass  = $this->layout->bs_leftClass;
                $this->rightClass = $this->layout->bs_rightClass;
                $this->mainClass  = $this->layout->bs_mainClass;
                break;

            default:
                $this->useGrid = false;

                return;
        }

        $this->useGrid = true;
    }

    /**
     * Add the schema attributes.
     *
     * @param string     $sectionId  Section id.
     * @param bool       $inside     If true no schema attributes are added.
     * @param Attributes $attributes Section attributes.
     */
    private function addSchemaAttributes(string $sectionId, bool $inside, Attributes $attributes): void
    {
        if ($inside) {
            return;
        }

        switch ($sectionId) {
            case self::MAIN:
                $attributes->setAttribute('itemscope', true);
                $attributes->setAttribute('itemtype', 'http://schema.org/WebPageElement');
                $attributes->setAttribute('itemprop', 'mainContentOfPage');
                break;

            case self::HEADER:
                $attributes->setAttribute('itemscope', true);
                $attributes->setAttribute('itemtype', 'http://schema.org/WPHeader');
                break;

            default:
                // Do nothing.
        }
    }
}
