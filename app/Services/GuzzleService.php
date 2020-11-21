<?php


namespace App\Services;


use App\Contracts\HttpInterface;
use GuzzleHttp\Client;

class GuzzleService implements HttpInterface
{
    protected $client;
    protected $datas = [];
    protected $headers = [];
    protected $uri;

    public function __construct()
    {
        $this->client = new Client(['verify' => false, 'timeout' => 30, 'headers' => ['Content-Type' => 'application/json']]);
    }

    public function get()
    {
        return $this->request('GET', 'query');
    }

    public function post()
    {
        return $this->request('POST', 'json');
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    protected function getUri()
    {
        return $this->uri;
    }

    public function setDatas(array $datas): void
    {
        $this->datas = $datas;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    protected function request($method, $dataType)
    {
        try {
            return $this->sendRequest($method, $dataType);
        } catch (Exception $e) {
            return $e;
        }
    }

    protected function sendRequest($method, $dataType)
    {
        $this->checkUri();

        return $this->client->request($method, $this->getUri(), $this->getOptions($dataType));
    }

    protected function checkUri()
    {
        if (is_null($this->getUri())) {
            throw new \Exception('É necessário informar a URI.');
        }
    }

    protected function getOptions($dataType): array
    {
        return [$dataType => $this->datas, 'headers' => $this->headers];
    }
}
