<?php

namespace SensioLabs\Consul;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

use SensioLabs\Consul\Exception\ClientException;
use SensioLabs\Consul\Exception\ServerException;

class Client
{
    private $client;
    private $logger;

    public function __construct(array $options = [], LoggerInterface $logger = null, GuzzleClient $client = null)
    {
        $options = array_replace([
            'base_uri' => 'http://127.0.0.1:8500',
            'headers' => [
                'User-Agent' => 'Consul-PHP-SDK/1.0',
                'Content-Type' => 'application/json',
            ],
        ], $options);

        $this->client = $client ?: new GuzzleClient($options);
        $this->logger = $logger ?: new NullLogger();
    }

    public function get($url = null, array $options = [])
    {
        return $this->send(new Request('GET', $url), $options);
    }

    public function head($url, array $options = [])
    {
        return $this->send(new Request('HEAD', $url), $options);
    }

    public function delete($url, array $options = [])
    {
        return $this->send(new Request('DELETE', $url), $options);
    }

    public function put($url, array $options = [])
    {
        return $this->send(new Request('PUT', $url), $options);
    }

    public function patch($url, array $options = [])
    {
        return $this->send(new Request('PATCH', $url), $options);
    }

    public function post($url, array $options = [])
    {
        return $this->send(new Request('POST', $url), $options);
    }

    public function options($url, array $options = [])
    {
        return $this->send(new Request('OPTIONS', $url), $options);
    }

    public function send(RequestInterface $request, $options = [])
    {
        $this->logger->info(sprintf('%s "%s"', $request->getMethod(), $request->getUri()));
        $this->logger->debug(sprintf("Request:\n%s\n%s\n%s", $request->getUri(), $request->getMethod(), json_encode($request->getHeaders())));

        try {
            $response = $this->client->send($request, $options);
        } catch (TransferException $e) {
            $message = sprintf('Something went wrong when calling consul (%s).', $e->getMessage());

            $this->logger->error($message);

            throw new ServerException($message);
        }

        $this->logger->debug(sprintf("Response:\n%s\n%s\n%s", $response->getStatusCode(), json_encode($response->getHeaders()), $response->getBody()->getContents()));

        if (400 <= $response->getStatusCode()) {
            $message = sprintf('Something went wrong when calling consul (%s - %s).', $response->getStatusCode(), $response->getReasonPhrase());

            $this->logger->error($message);

            $message .= "\n$response";
            if (500 <= $response->getStatusCode()) {
                throw new ServerException($message);
            }

            throw new ClientException($message);
        }

        return $response;
    }
}
