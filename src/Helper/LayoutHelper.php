<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace ContaoBootstrap\Layout\Helper;

use Contao\LayoutModel;
use Netzmacht\Html\Attributes;

/**
 * LayoutHelper is a template helper for the fe_bootstrap template.
 *
 * @package ContaoBootstrap\Layout\Helper
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
    private $template;

    /**
     * Main css class.
     *
     * @var string
     */
    private $mainClass;

    /**
     * Left css class.
     *
     * @var string
     */
    private $leftClass;

    /**
     * Right css class.
     *
     * @var string
     */
    private $rightClass;

    /**
     * Use grid column system.
     *
     * @var bool
     */
    private $useGrid;

    /**
     * Page layout.
     *
     * @var LayoutModel
     */
    private $layout;

    /**
     * Construct.
     *
     * @param \FrontendTemplate $template   Frontend page template.
     * @param LayoutModel       $pageLayout Layout model.
     */
    protected function __construct($template, $pageLayout)
    {
        $this->template = $template;
        $this->layout   = $pageLayout;

        $this->initialize();
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
        // For simplicity in the template, just let it here.
        $layout = \Controller::getContainer()->get('contao_bootstrap.environment')->getLayout();

        return new static($template, $layout);
    }

    /**
     * Check if page layout is a bootstrap layout.
     *
     * @return bool
     */
    public function isBootstrapLayout()
    {
        return ($this->layout && $this->layout->layoutType == 'bootstrap');
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
    public function isGridActive()
    {
        return $this->layout->cols != '1cl' && $this->layout->cols != '';
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
    private function addSchemaAttributes($sectionId, $inside, Attributes $attributes)
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
