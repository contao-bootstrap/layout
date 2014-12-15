<?php

namespace Netzmacht\Bootstrap\Layout\Helper;

use Netzmacht\Contao\FlexibleSections\Helper as FlexibleSections;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

class LayoutHelper
{
    const LEFT   = 'left';
    const RIGHT  = 'right';
    const MAIN   = 'main';
    const HEADER = 'header';
    const FOOTER = 'footer';

    /**
     * @var \FrontendTemplate
     */
    protected $template;

    /**
     * @var string
     */
    protected $mainClass;

    /**
     * @var string
     */
    protected $leftClass;

    /**
     * @var string
     */
    protected $rightClass;

    /**
     * @var bool
     */
    protected $useGrid;

    /**
     * @var FlexibleSections
     */
    protected $flexibleSections;

    /**
     * @param \FrontendTemplate $template
     */
    protected function __construct($template)
    {
        $this->template         = $template;
        $this->flexibleSections = new FlexibleSections($template);
    }

    /**
     * @return \LayoutModel|null
     */
    public static function getPageLayout()
    {
        return Bootstrap::getPageLayout();
    }

    /**
     * @param \FrontendTemplate $template
     * @return static
     */
    public static function forTemplate(\FrontendTemplate $template)
    {
        /** @var LayoutHelper $helper */
        $helper = new static($template);
        $helper->initialize();

        return $helper;
    }

    /**
     * @return bool
     */
    public static function isBootstrapLayout()
    {
        $layout = static::getPageLayout();

        return ($layout && $layout->layoutType == 'bootstrap');
    }

    /**
     * @param $id
     * @param bool $inside
     * @return \Netzmacht\Html\Attributes
     */
    public function getAttributes($id, $inside=false)
    {
        $layout     = static::getPageLayout();
        $attributes = new Attributes();

        if ($inside) {
            $attributes->addClass('inside');
        } else {
            $attributes->setId($id);
        }

        if ($id == static::FOOTER || $id == static::HEADER) {
            $key = sprintf('bootstrap_%sClass', $id);

            if ($layout->$key) {
                $attributes->addClass($layout->$key);
            }
        } elseif (static::isGridActive()) {
            $key = sprintf('%sClass', $id);

            if ($this->$key) {
                $attributes->addClass($this->$key);
            }
        }

        return $attributes;
    }

    /**
     * @return bool
     */
    public function isGridActive()
    {
        $layout = static::getPageLayout();

        return $layout->cols != '1cl' && $layout->cols != '';
    }

    /**
     * @param $id
     * @param string $template
     * @param bool $renderEmpty
     * @return string
     */
    public function getCustomSection($id, $template=null, $renderEmpty=false)
    {
        return $this->flexibleSections->getCustomSection($id, $template, $renderEmpty);
    }

    /**
     * @param $position
     * @param string $template
     * @return string
     */
    public function getCustomSections($position, $template='block_sections')
    {
        return $this->flexibleSections->getCustomSections($position, $template);
    }

    /**
     * Initialize the system
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
                $this->leftClass           = $layout->bootstrap_leftClass;
                $this->mainClass           = $layout->bootstrap_mainClass;
                break;

            case '2clr':
                $this->rightClass          = $layout->bootstrap_rightClass;
                $this->mainClass           = $layout->bootstrap_mainClass;
                break;

            case '3cl':
                $this->leftClass           = $layout->bootstrap_leftClass;
                $this->rightClass          = $layout->bootstrap_rightClass;
                $this->mainClass           = $layout->bootstrap_mainClass;
                break;

            default:
                $this->useGrid = false;

                return;
        }

        $this->useGrid = true;
    }
}
