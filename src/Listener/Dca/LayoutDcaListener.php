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
    protected static string $name = 'tl_layout';

    /**
     * @param Config     $config     Bootstrap config.
     * @param Connection $connection Database connection.
     */
    public function __construct(
        private readonly Config $config,
        private readonly Connection $connection,
        DcaManager $dcaManager,
    ) {
        parent::__construct($dcaManager);
    }

    /**
     * Set the default viewport.
     *
     * @Callback(table="tl_layout", target="config.onload")
     */
    public function setDefaultViewPort(): void
    {
        $this->getDefinition()->set(
            ['fields', 'viewport', 'default'],
            $this->config->get(['layout', 'viewport'], ''),
        );
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
        $supportedFrameworkCss = $this->config->get(['layout', 'contao_framework_css'], []);

        $dataContainer->activeRecord->framework = array_values(
            array_filter(
                StringUtil::deserialize($dataContainer->activeRecord->framework, true),
                static fn (string $value) => $supportedFrameworkCss[$value] ?? true,
            ),
        );

        $this->connection->executeStatement(
            'UPDATE tl_layout SET framework = :framework WHERE id= :id',
            [
                'framework' => serialize($dataContainer->activeRecord->framework),
                'id'        => $dataContainer->id,
            ],
        );
    }

    /** @Callback(table="tl_layout", target="fields.framework.load") */
    public function frameworkOptions(string $value, DataContainer $dataContainer): string
    {
        if (! $dataContainer->activeRecord || $dataContainer->activeRecord->layoutType !== 'bootstrap') {
            return $value;
        }

        /** @psalm-var array<string,bool> $supportedFrameworkCss */
        $supportedFrameworkCss = $this->config->get(['layout', 'contao_framework_css'], []);
        $files                 = array_keys(array_filter($supportedFrameworkCss));

        $this->getDefinition()->set(['fields', 'framework', 'options'], $files);

        return $value;
    }
}
