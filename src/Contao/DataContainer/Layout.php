<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Layout\Contao\DataContainer;


/**
 * Dca Helper class for tl_layout.
 *
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Layout
{
    /**
     * Disable contao framework.
     *
     * @param mixed          $value         Framework value.
     * @param \DataContainer $dataContainer Data container driver.
     *
     * @return mixed
     */
    public function disableFramework($value, \DataContainer $dataContainer)
    {
        if ($value == 'bootstrap' && $dataContainer->activeRecord->framework) {
            $dataContainer->activeRecord->framework = null;
            \Database::getInstance()
                ->prepare('UPDATE tl_layout %s WHERE id=?')
                ->set(array('framework' => null))
                ->execute($dataContainer->id);
        }

        return $value;
    }
}
