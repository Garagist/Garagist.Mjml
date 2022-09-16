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
