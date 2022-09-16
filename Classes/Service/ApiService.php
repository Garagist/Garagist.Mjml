<?php

declare(strict_types=1);

namespace Garagist\Mjml\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Neos\Flow\Annotations as Flow;
use Psr\Log\LoggerInterface;
use function sprintf;

/**
 *
 * @Flow\Scope("singleton")
 */
class ApiService
{

    /**
     * @var array
     * @Flow\InjectConfiguration()
     */
    protected $configuration;

    /**
     * @Flow\Inject(name="Garagist.Mjml:MjmlLogger")
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param string $html
     * @param string|null $url for debug
     * @return string
     * @throws Exception
     */
    public function compileMjml(string $mjml, ?string $url = null): string
    {
        $client = new Client();

        try {
            $response = $client->request(
                'POST',
                $this->configuration['apiEndpoint'],
                [
                    'headers' => [
                        'Content-Type' => 'text/plain'
                    ],
                    'body' => $mjml,
                ]
            );
        } catch (GuzzleException $exception) {
            $message = $exception->getMessage();

            $logMessage = 'Calling MJML API ';
            if (isset($url)) {
                $logMessage .= sprintf('(%s) ', $url);
            }
            $logMessage .= sprintf('failed with reason: %s', $message);
            $this->logger->error($logMessage);

            return $message;
        }

        $logMessage = 'Successfully called MJML API';
        if (isset($url)) {
            $logMessage .= sprintf(' (%s)', $url);
        }

        $this->logger->debug($logMessage);
        return (string) $response->getBody();
    }
}
