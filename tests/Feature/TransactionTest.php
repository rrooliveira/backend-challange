<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @dataProvider dataSet
     */
    public function processTransactionWithSuccess($value, $payer, $payee)
    {
        $data = [
            'value' => $value,
            'payer' => $payer,
            'payee' => $payee
        ];

        $response = $this->post('/api/transaction', $data);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function processTransactionWithError()
    {
        $response = $this->post('/api/transaction');

        $response->assertStatus(302);
    }

    public function dataSet()
    {
        return [
            [
                'value' => 100,
                'payer' => 1,
                'payee' => 2
            ]
        ];
    }
}
