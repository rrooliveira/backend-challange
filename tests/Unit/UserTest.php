<?php

namespace Tests\Unit;


use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    private $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = app()->make('\App\Services\UserService');
    }

    /**
     * @test
     */
    public function checkIfThePayerOrPayeeIsValid()
    {
        //User Invalid
        $response = $this->userService->checkIfUserIsValid(0);
        $this->assertFalse($response);

        //User Valid
        $response = $this->userService->checkIfUserIsValid(1);
        $this->assertInstanceOf(User::class, $response);

    }

    /**
     * @test
     */
    public function checkIfUserCanTransferValue()
    {
        //User Valid
        $userC = factory(User::class)->make();
        $response = $this->userService->checkIfUserCanTransferValue($userC);
        $this->assertTrue($response);

        //User Invalid
        $userS = factory(User::class)->make([
            'document' => '66.666.666/6666-66',
            'type_user' => 'S'
        ]);
        $response = $this->userService->checkIfUserCanTransferValue($userS);
        $this->assertFalse($response);
    }
}
