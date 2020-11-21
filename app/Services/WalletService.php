<?php


namespace App\Services;


use App\Contracts\WalletInterface;
use App\Model\User;
use App\Model\Wallet;
use App\Repositories\WalletRepository;

class WalletService implements WalletInterface
{
    protected $walletRepository;
    protected $userService;

    public function __construct(
        WalletRepository $walletRepository,
        UserService $userService
    )
    {
        $this->walletRepository = $walletRepository;
        $this->userService = $userService;
    }

    public function debit(User $payer, float $value): bool
    {
        $wallet = $this->walletRepository->findByColumn('user_id', $payer->id)->first();
        if (!$wallet instanceof Wallet) {
            return false;
        }

        $attributes = [
            'balance' => ($wallet->balance - $value)
        ];

        return $this->walletRepository->update($wallet->id, $attributes);
    }

    public function credit(User $payee, float $value)
    {
        $wallet = $this->walletRepository->findByColumn('user_id', $payee->id)->first();
        if (!$wallet instanceof Wallet) {
            return false;
        }

        $attributes = [
            'balance' => ($wallet->balance + $value)
        ];

        return $this->walletRepository->update($wallet->id, $attributes);
    }
}
