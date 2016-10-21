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
     * Construct.
     *
     * @param \FrontendTemplate $template Frontend page template.
     */
    protected function __construct($template)
    {
        $this->template = $template;

        $this->initialize();
    }

    /**
     * Get page layout.
     *
     * @return \LayoutModel|null
     */
    public static function getPageLayout()
    {
        return \Controller::getContainer()->get('contao_bootstrap.environment')->getLayout();
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

        if (!$inside) {
            switch($sectionId) {
                case static::MAIN:
                    $attributes->setAttribute('itemscope', true);
                    $attributes->setAttribute('itemtype', 'http://schema.org/WebPageElement');
                    $attributes->setAttribute('itemprop', 'mainContentOfPage');
                    break;

                case static::HEADER:
                    $attributes->setAttribute('itemscope', true);
                    $attributes->setAttribute('itemtype', 'http://schema.org/WPHeader');
                    break;
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
