<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Listener\Dca;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\StringUtil;
use ContaoBootstrap\Core\Config;
use Doctrine\DBAL\Connection;
use Netzmacht\Contao\Toolkit\Dca\DcaManager;
use Netzmacht\Contao\Toolkit\Dca\Listener\AbstractListener;

use function array_filter;
use function array_keys;
use function array_values;
use function serialize;

final class LayoutDcaListener extends AbstractListener
{
    /** @var string */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected static $name = 'tl_layout';

    /**
     * Bootstrap config.
     */
    private Config $config;

    /**
     * Database connection.
     */
    private Connection $connection;

    /**
     * @param Config     $config     Bootstrap config.
     * @param Connection $connection Database connection.
     */
    public function __construct(Config $config, Connection $connection, DcaManager $dcaManager)
    {
        parent::__construct($dcaManager);

        $this->config     = $config;
        $this->connection = $connection;
    }

    /**
     * Set the default viewport.
     *
     * @Callback(table="tl_layout", target="config.onload")
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setDefaultViewPort(): void
    {
        $GLOBALS['TL_DCA']['tl_layout']['fields']['viewport']['default'] = $this->config->get('layout.viewport', '');
    }

    /**
     * Disable contao framework.
     *
     * @Callback(table="tl_layout", target="config.onsubmit")
     */
    public function disableFramework(DataContainer $dataContainer): void
    {
        if (! $dataContainer->activeRecord) {
            return;
        }

        if ($dataContainer->activeRecord->layoutType !== 'bootstrap' || ! $dataContainer->activeRecord->framework) {
            return;
        }

        /** @psalm-var array<string,bool> $supportedFrameworkCss */
        $supportedFrameworkCss = $this->config->get('layout.contao_framework_css', []);

        $dataContainer->activeRecord->framework = array_values(
            array_filter(
                StringUtil::deserialize($dataContainer->activeRecord->framework, true),
                static fn (string $value) => $supportedFrameworkCss[$value] ?? true,
            )
        );

        $this->connection->executeStatement(
            'UPDATE tl_layout SET framework = :framework WHERE id= :id',
            [
                'framework' => serialize($dataContainer->activeRecord->framework),
                'id' => $dataContainer->id,
            ]
        );
    }

    /**
     * @Callback(table="tl_layout", target="fields.framework.load")
     */
    public function frameworkOptions(string $value, DataContainer $dataContainer): string
    {
        if (! $dataContainer->activeRecord || $dataContainer->activeRecord->layoutType !== 'bootstrap') {
            return $value;
        }

        /** @psalm-var array<string,bool> $supportedFrameworkCss */
        $supportedFrameworkCss = $this->config->get('layout.contao_framework_css', []);
        $files                 = array_keys(array_filter($supportedFrameworkCss));

        $this->getDefinition()->set(['fields', 'framework', 'options'], $files);

        return $value;
    }
}
