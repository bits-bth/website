<?php

namespace bits\DI;

use bits\Markdown\Markdown;
use bits\Request\Request;
use bits\Response\Response;
use bits\Router\Router;
use bits\Translation\I18n;
use Throwable;

/**
 * @property Request request
 * @property Request req
 * @property Response response
 * @property Response res
 * @property Router router
 * @property Markdown markdown
 * @property Markdown md
 * @property I18n i18n
 */
class DI
{
    private $inactive = [];
    private $active = [];

    /**
     * Adds a service to be able to be loaded.
     * HAS TO EXTEND \bits\Service\ServiceProvider.
     *
     * @example
     * addService(\vendor\MyService)
     *
     * @param string $serviceClass The service to be added.
     */
    public function addService(string $serviceClass)
    {
        if (is_subclass_of($serviceClass, ServiceProvider::class)) {
            $this->inactive[] = $serviceClass;
        }
    }

    public function addServices(array $serviceClasses)
    {
        foreach ($serviceClasses as $serviceClass) {
            $this->addService($serviceClass);
        }
    }

    /**
     * Loads a service to be used.
     *
     * @param $service string The service to be loaded
     * @return ServiceProvider|null Returns the service provider associated with the service or null
     * @throws \Exception If the service provider boot function throws an exception
     */
    private function loadService($service)
    {
        foreach ($this->inactive as $inactiveService) {
            if ($inactiveService::name() === $service || in_array($service, $inactiveService::alias())) {
                $instance = new $inactiveService();
                if ($instance instanceof ServiceProvider) {
                    $instance->setDi($this);
                    try {
                        $instance->boot();
                    } catch (Throwable $e) {
                        throw new \Exception("Exception thrown while $inactiveService was booting", 1, $e);
                    }
                    $this->active[$instance::name()] = $instance;
                    foreach ($instance::alias() as $alias) {
                        $this->active[$alias] = $instance;
                    }
                    return $instance;
                }
            }
        }
        return null;
    }

    public function has(string $service): bool
    {
        foreach ($this->inactive as $loadedService) {
            if ($loadedService::name() === $service || in_array($service, $loadedService::alias())) {
                return true;
            }
        }
        return false;
    }

    public function get(string $service)
    {
        return $this->active[$service] ?? $this->loadService($service);
    }

    public function __get(string $service)
    {
        return $this->get($service);
    }
}
