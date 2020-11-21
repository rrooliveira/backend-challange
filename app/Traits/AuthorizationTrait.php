<?php


namespace App\Traits;


use App\Enum\TransactionEnum;
use App\Services\GuzzleService;

trait AuthorizationTrait
{
    public function getAuthorization()
    {
        $client = new GuzzleService();
        $client->setUri(TransactionEnum::ENDPOINT_AUTHORIZATION);
        $response = $client->get();

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $json = json_decode($response->getBody()->getContents());

        if ($json->message == 'Autorizado') {
            return true;
        }

        return false;
    }
}
