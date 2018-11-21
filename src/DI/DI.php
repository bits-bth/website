<?php

namespace bits\DI;

use Exception;
use bits\Common\Util;
use bits\Request\Request;
use bits\Response\Response;

/**
 * @property Request request
 * @property Request req
 * @property Response response
 * @property Response res
 */
class DI
{
    private $services = [];
    private $loadedServices = [];

    public function loadServices($services): void
    {
        if (is_string($services) && is_dir($services)) {
            foreach (glob("$services/*.php") as $file) {
                $service = require "$file";
                $this->createService($service);
            }
        } else if (is_array($services)) {
            foreach ($services as $service) {
                $this->createService($service);
            }
        }
    }

    public function createService(array $service): void
    {
        if (!Util::is_assoc($service)) {
            foreach ($service as $innerService) {
                $this->createService($innerService);
            }
            return;
        }
        $this->services[$service["name"]] = $service["callback"];
    }

    /**
     * @param string $service
     * @return mixed|null
     * @throws \Exception
     */
    public function load(string $service)
    {
        if (!isset($this->services[$service]))
            return null;
        $callback = $this->services[$service];

        if (is_callable($callback)) $instance = $callback();
        elseif (is_object($callback)) $instance = $callback;
        elseif (is_string($callback)) $instance = new $callback();
        else throw new Exception("Unable to instantiate '" . $service . "' service!");

        $this->loadedServices[$service] = $instance;
        return $instance;
    }

    public function has(string $service): bool
    {
        return isset($this->loadedServices[$service]);
    }

    public function get(string $service): object
    {
        if ($this->has($service)) {
            return $this->loadedServices[$service];
        }
        return $this->load($service);
    }

    public function __get(string $service): object
    {
        return $this->get($service);
    }
}
