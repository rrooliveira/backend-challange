<?php


namespace App\Traits;


use App\Enum\TransactionEnum;
use App\Services\GuzzleService;

trait NotificationTrait
{
    public function getNotification(): bool
    {
        $client = new GuzzleService();
        $client->setUri(TransactionEnum::ENDPOINT_NOTIFICATION);
        $response = $client->get();

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $json = json_decode($response->getBody()->getContents());

        if ($json->message == 'Enviado') {
            return true;
        }

        return false;
    }
}
