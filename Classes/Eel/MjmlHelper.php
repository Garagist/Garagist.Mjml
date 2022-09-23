<?php

declare(strict_types=1);

namespace Garagist\Mjml\Eel;

use Neos\Flow\Annotations as Flow;
use Garagist\Mjml\Service\ApiService;
use Neos\Eel\ProtectedContextAwareInterface;

class MjmlHelper implements ProtectedContextAwareInterface
{

    /**
     * @Flow\Inject
     * @var ApiService
     */
    protected $apiService;

    /**
     * @var array
     * @Flow\InjectConfiguration(path="theme")
     */
    protected $themeConfiguration;

    /**
     * Return a theme setting
     *
     * @param string $path
     * @return string|null
     */
    public function theme(string $path): ?string
    {
        $parts = explode('.', $path);
        $lastPart = array_pop($parts);
        $config = $this->themeConfiguration;
        foreach ($parts as $part) {
            $config = $this->getThemeValue($config, $part, false);
        }
        $config = $this->getThemeValue($config, $lastPart, true);
        if (is_array($config) || $config == null || $config == '') {
            return null;
        }
        return (string) $config;
    }

    /**
     * Try to get the theme value, if not found, return the default value (if set)
     *
     * @param array $config
     * @param string $part
     * @param bool $isLast
     * @return mixed
     */
    protected function getThemeValue(array $config, string $part, $isLast = false)
    {
        if (!array_key_exists($part, $config)) {
            return null;
        }
        $config = $config[$part];

        if ($isLast && is_array($config) && array_key_exists('DEFAULT', $config)) {
            return $config['DEFAULT'];
        }

        return $config;
    }

    /**
     * Compile the html with MJML
     *
     * @param string $html
     * @param string|null $url for log output
     * @return string
     */
    public function compile(string $mjml, ?string $url = null): string
    {
        return $this->apiService->compileMjml($mjml, $url);
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
