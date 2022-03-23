<?php

/**
 * Contao Bootstrap Layout.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2018 netzmacht creative David Molineus
 * @license    LGPL 3.0-or-later
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Helper;

use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Netzmacht\Html\Attributes;

/**
 * LayoutHelper is a template helper for the fe_bootstrap template.
 *
 * @package ContaoBootstrap\Layout\Helper
 */
final class LayoutHelper
{
    const LEFT      = 'left';
    const RIGHT     = 'right';
    const MAIN      = 'main';
    const HEADER    = 'header';
    const FOOTER    = 'footer';
    const WRAPPER   = 'wrapper';
    const CONTAINER = 'container';

    /**
     * Frontend page template.
     *
     * @var \FrontendTemplate
     */
    private FrontendTemplate $template;

    /**
     * Main css class.
     *
     * @var string
     */
    private string $mainClass;

    /**
     * Left css class.
     *
     * @var string
     */
    private string $leftClass;

    /**
     * Right css class.
     *
     * @var string
     */
    private string $rightClass;

    /**
     * Use grid column system.
     *
     * @var bool
     */
    private bool $useGrid;

    /**
     * Page layout.
     *
     * @var LayoutModel
     */
    private LayoutModel $layout;

    /**
     * Construct.
     *
     * @param FrontendTemplate $template   Frontend page template.
     * @param LayoutModel      $pageLayout Layout model.
     */
    protected function __construct(FrontendTemplate $template, LayoutModel $pageLayout)
    {
        $this->template = $template;
        $this->layout   = $pageLayout;

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
        return new static($template, $template->bootstrapEnvironment->getLayout());
    }

    /**
     * Check if page layout is a bootstrap layout.
     *
     * @return bool
     */
    public function isBootstrapLayout(): bool
    {
        return ($this->layout && $this->layout->layoutType === 'bootstrap');
    }

    /**
     * Get attributes for a specific section.
     *
     * @param string $sectionId The section id.
     * @param bool   $inside    If true the inside class is added. Otherwhise $sectionId is set as id attribute.
     *
     * @return Attributes
     */
    public function getAttributes(string $sectionId, bool $inside = false): Attributes
    {
        $attributes = new Attributes();

        if ($inside) {
            $attributes->addClass('inside');
        } else {
            $attributes->setId($sectionId);
        }

        if (in_array($sectionId, array(static::FOOTER, static::HEADER))) {
            $key = sprintf('bs_%sClass', $sectionId);

            if ($this->layout->$key) {
                $attributes->addClass($this->layout->$key);
            }
        } elseif (in_array($sectionId, array(static::CONTAINER, static::WRAPPER))) {
            $class = $this->layout->bs_containerClass;

            if ($class && $this->layout->bs_containerElement === $sectionId) {
                $attributes->addClass($class);
            }
        } elseif (static::isGridActive()) {
            $key = sprintf('%sClass', $sectionId);

            if ($this->$key) {
                $attributes->addClass($this->$key);
            }
        }

        $this->addSchemaAttributes($sectionId, $inside, $attributes);

        return $attributes;
    }

    /**
     * Check if grid is active.
     *
     * @return bool
     */
    public function isGridActive(): bool
    {
        return $this->layout->cols != '1cl' && $this->layout->cols != '';
    }

    /**
     * Initialize the helper.
     *
     * @return void
     */
    private function initialize(): void
    {
        if (!$this->isBootstrapLayout()) {
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
     *
     * @return void
     */
    private function addSchemaAttributes(string $sectionId, bool $inside, Attributes $attributes): void
    {
        if ($inside) {
            return;
        }

        switch ($sectionId) {
            case static::MAIN:
                $attributes->setAttribute('itemscope', true);
                $attributes->setAttribute('itemtype', 'http://schema.org/WebPageElement');
                $attributes->setAttribute('itemprop', 'mainContentOfPage');
                break;

            case static::HEADER:
                $attributes->setAttribute('itemscope', true);
                $attributes->setAttribute('itemtype', 'http://schema.org/WPHeader');
                break;

            default:
                // Do nothing.
        }
    }
}
