<?php

/**
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
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
