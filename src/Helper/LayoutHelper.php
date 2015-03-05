<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Layout\Helper;

use Netzmacht\Contao\FlexibleSections\Helper as FlexibleSections;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * LayoutHelper is a template helper for the fe_bootstrap template.
 *
 * @package Netzmacht\Bootstrap\Layout\Helper
 */
class LayoutHelper
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
    protected $template;

    /**
     * Main css class.
     *
     * @var string
     */
    protected $mainClass;

    /**
     * Left css class.
     *
     * @var string
     */
    protected $leftClass;

    /**
     * Right css class.
     *
     * @var string
     */
    protected $rightClass;

    /**
     * Use grid column system.
     *
     * @var bool
     */
    protected $useGrid;

    /**
     * Flexible section helper.
     *
     * @var FlexibleSections
     */
    protected $flexibleSections;

    /**
     * Construct.
     *
     * @param \FrontendTemplate $template Frontend page template.
     */
    protected function __construct($template)
    {
        $this->template         = $template;
        $this->flexibleSections = new FlexibleSections($template);

        $this->initialize();
    }

    /**
     * Get page layout.
     *
     * @return \LayoutModel|null
     */
    public static function getPageLayout()
    {
        return Bootstrap::getPageLayout();
    }

    /**
     * Instantiate helper for frontend page template.
     *
     * @param \FrontendTemplate $template Frontend page template.
     *
     * @return static
     */
    public static function forTemplate(\FrontendTemplate $template)
    {
        return new static($template);
    }

    /**
     * Check if page layout is a bootstrap layout.
     *
     * @return bool
     */
    public static function isBootstrapLayout()
    {
        $layout = static::getPageLayout();

        return ($layout && $layout->layoutType == 'bootstrap');
    }

    /**
     * Get attributes for a specific section.
     *
     * @param string $sectionId The section id.
     * @param bool   $inside    If true the inside class is added. Otherwhise $sectionId is set as id attribute.
     *
     * @return Attributes
     */
    public function getAttributes($sectionId, $inside = false)
    {
        $layout     = static::getPageLayout();
        $attributes = new Attributes();

        if ($inside) {
            $attributes->addClass('inside');
        } else {
            $attributes->setId($sectionId);
        }

        if (in_array($sectionId, array(static::FOOTER, static::HEADER))) {
            $key = sprintf('bootstrap_%sClass', $sectionId);

            if ($layout->$key) {
                $attributes->addClass($layout->$key);
            }
        } elseif (in_array($sectionId, array(static::CONTAINER, static::WRAPPER))) {
            $class = $layout->bootstrap_containerClass;

            if ($class && $layout->bootstrap_containerElement === $sectionId) {
                $attributes->addClass($class);
            }
        } elseif (static::isGridActive()) {
            $key = sprintf('%sClass', $sectionId);

            if ($this->$key) {
                $attributes->addClass($this->$key);
            }
        }

        return $attributes;
    }

    /**
     * Check if grid is active.
     *
     * @return bool
     */
    public function isGridActive()
    {
        $layout = static::getPageLayout();

        return $layout->cols != '1cl' && $layout->cols != '';
    }

    /**
     * Get custom section.
     *
     * @param string $sectionId   Section id.
     * @param string $template    Section template.
     * @param bool   $renderEmpty Force section being rendered when being empty.
     *
     * @return string
     */
    public function getCustomSection($sectionId, $template = null, $renderEmpty = false)
    {
        return $this->flexibleSections->getCustomSection($sectionId, $template, $renderEmpty);
    }

    /**
     * Get custom sections.
     *
     * @param string $position Section position.
     * @param string $template Block template.
     *
     * @return string
     */
    public function getCustomSections($position, $template = 'block_sections')
    {
        return $this->flexibleSections->getCustomSections($position, $template);
    }

    /**
     * Initialize the helper.
     *
     * @return void
     */
    private function initialize()
    {
        if (!$this->isBootstrapLayout()) {
            return;
        }

        $layout = static::getPageLayout();

        // only apply viewport if not contao 3.3 is used
        if ($layout->viewport && !$this->template->viewport && version_compare(VERSION, '3.3', '<')) {
            $this->template->viewport = sprintf('<meta name="viewport" content="%s">', $layout->viewport);
        }

        switch ($layout->cols) {
            case '2cll':
                $this->leftClass = $layout->bootstrap_leftClass;
                $this->mainClass = $layout->bootstrap_mainClass;
                break;

            case '2clr':
                $this->rightClass = $layout->bootstrap_rightClass;
                $this->mainClass  = $layout->bootstrap_mainClass;
                break;

            case '3cl':
                $this->leftClass  = $layout->bootstrap_leftClass;
                $this->rightClass = $layout->bootstrap_rightClass;
                $this->mainClass  = $layout->bootstrap_mainClass;
                break;

            default:
                $this->useGrid = false;

                return;
        }

        $this->useGrid = true;
    }
}
