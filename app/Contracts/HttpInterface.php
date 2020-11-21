<?php


namespace App\Contracts;


interface HttpInterface
{
    public function get();

    public function post();

    public function setUri(string $uri);

    public function setDatas(array $datas);

    public function setHeaders(array $headers);
}
