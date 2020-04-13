<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Symfony;

use App\Module\Employee\Infrastructure\EnumRegistry\EnumRegistry;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public const AVAILABLE_LOCALES = ['pl', 'en'];

    private string $appId;

    public function __construct(string $environment, bool $debug, string $appId = 'pl')
    {
        $this->appId = (null !== $appId) ? $appId : \getenv('APP');
        if (!$this->appId)
        {
            throw new \InvalidArgumentException('$appId is empty or no APP environment variable set!');
        }

        if (false === in_array($this->appId, self::AVAILABLE_LOCALES))
        {
            throw new \InvalidArgumentException(sprintf('APP ID: "%s" is not supported. Supported IDs are: %s;', $this->appId, implode(', ', self::AVAILABLE_LOCALES)));
        }
        parent::__construct($environment, $debug);
    }

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';

        foreach ($contents as $class => $envs)
        {
            if ($envs[$this->environment] ?? $envs['all'] ?? false)
            {
                yield new $class();
            }
        }
        EnumRegistry::register();
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__).'/../../../';
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('app_id', $this->appId);
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{app}/{' . $this->appId . '}/{config}' . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/{routes}/' . $this->environment . '/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
    }

    public function getCacheDir()
    {
        return $this->getProjectDir() . '/var/cache/' . $this->environment . '/' . $this->appId;
    }

    public function getLogDir()
    {
        return $this->getProjectDir() . '/var/log/' . $this->environment . '/' . $this->appId;
    }

}
