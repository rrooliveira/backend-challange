<?php

namespace Tests\Unit;


use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use DatabaseTransactions;

    private $walletService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletService = app()->make('\App\Services\WalletService');
    }

    /**
     * @test
     */
    public function generateCredit()
    {
        //Able to generate the credit
        $userAble = factory(User::class)->make([
            'id' => 1
        ]);

        $response = $this->walletService->credit($userAble, 100);
        $this->assertTrue($response);

        //Unable to generate the credit
        $userUnable = factory(User::class)->make([
            'id' => 0
        ]);
        $response = $this->walletService->credit($userUnable, 100);
        $this->assertFalse($response);

    }

    /**
     * @test
     */
    public function generateDebit()
    {
        //Able to generate the debit
        $userAble = factory(User::class)->make([
            'id' => 1
        ]);

        $response = $this->walletService->debit($userAble, 100);
        $this->assertTrue($response);

        //Unable to generate the debit
        $userUnable = factory(User::class)->make([
            'id' => 0
        ]);
        $response = $this->walletService->debit($userUnable, 100);
        $this->assertFalse($response);
    }
}
