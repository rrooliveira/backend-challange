<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    private $transactionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionService = app()->make('\App\Services\TransactionService');
    }

    /**
     * @test
     * @dataProvider dataSetSameUser
     */
    public function checkIfTheTransactionIsForSameUser($value, $payer, $payee)
    {
        $response = $this->transactionService->makeTransaction($value, $payer, $payee);
        $this->assertInstanceOf(\RuntimeException::class, $response);
    }

    /**
     * @test
     */
    public function checkIfPayerIsValidAndAbleToTransfer()
    {
        $response = $this->transactionService->checkPayerData(1);
        $this->assertTrue($response);

        $response = $this->transactionService->checkPayerData(6);
        $this->assertFalse($response);
    }

    public function dataSetSameUser()
    {
        return [
            [
                'value' => 100,
                'payer' => 1,
                'payee' => 1
            ]
        ];
    }
}
