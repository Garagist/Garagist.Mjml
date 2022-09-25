<?php

declare(strict_types=1);

namespace Garagist\Mjml\Service;

use Neos\Flow\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
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
        $endpoint = $this->configuration['apiEndpoint'];
        $html = '';

        try {
            if ($endpoint === true || str_starts_with($endpoint, 'https://api.mjml.io/')) {
                $response = $client->request(
                    'POST',
                    'https://api.mjml.io/v1/render',
                    [
                        RequestOptions::HEADERS => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Accepts' => 'application/json',
                        ],
                        RequestOptions::AUTH => [
                            $this->configuration['applicationID'],
                            $this->configuration['secretKey']
                        ],
                        RequestOptions::JSON => [
                            'mjml' => $mjml,
                        ],
                    ]
                );
                $contents = $response->getBody()->getContents();
                $json = json_decode($contents, true);
                $html = $json['html'];
            } else {
                $response = $client->request(
                    'POST',
                    $endpoint,
                    [
                        RequestOptions::HEADERS => [
                            'Content-Type' => 'text/plain'
                        ],
                        RequestOptions::AUTH => [
                            $this->configuration['applicationID'],
                            $this->configuration['secretKey']
                        ],
                        RequestOptions::BODY => $mjml,
                    ]
                );
                $html = $response->getBody();
            }
        } catch (ClientException $exception) {
            $message = $exception->getResponse()->getBody()->getContents();

            $logMessage = 'Calling MJML API ';
            if (isset($url)) {
                $logMessage .= sprintf('(%s) ', $url);
            }
            $logMessage .= sprintf('failed with reason: %s', $message);
            $this->logger->error($logMessage);

            throw new Exception($message, 1664127843);
        }

        $logMessage = 'Successfully called MJML API';
        if (isset($url)) {
            $logMessage .= sprintf(' (%s)', $url);
        }

        $this->logger->debug($logMessage);
        return (string) $html;
    }
}
