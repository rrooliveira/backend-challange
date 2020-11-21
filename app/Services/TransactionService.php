<?php


namespace App\Services;


use App\Model\Transaction;
use App\Model\User;
use App\Model\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Traits\AuthorizationTrait;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    use AuthorizationTrait, NotificationTrait;

    public $transactionRepository;
    public $walletRepository;
    public $userService;
    public $walletService;

    public function __construct(
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository,
        UserService $userService,
        WalletService $walletService
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->userService = $userService;
        $this->walletService = $walletService;
    }

    public function makeTransaction(float $value, int $payer, int $payee)
    {
        try {
            DB::beginTransaction();

            if ($payer == $payee) {
                throw new \RuntimeException('Não é permitido efetuar a transfêrencia para o mesmo usuário.');
            }

            $dataChecked = $this->checkDataForTransaction($value, $payer, $payee);

            if ($dataChecked instanceof \RuntimeException) {
                throw $dataChecked;
            }

            //Payer User
            $payerUser = $this->userService->checkIfUserIsValid($payer);

            //Paye User
            $payeeUser = $this->userService->checkIfUserIsValid($payee);

            $transaction = $this->processTransaction($value, $payerUser, $payeeUser);
            if ($transaction instanceof \RuntimeException) {
                throw $transaction;
            }

            DB::commit();

            return true;
        } catch (\RuntimeException $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function checkDataForTransaction(float $value, int $payer, int $payee)
    {
        try {
            //Check if the Payer is correct
            $payerValidate = $this->checkPayerData($payer);
            if (!$payerValidate) {
                throw new \RuntimeException('Cadastro não localizado em nosso sistema ou não tem permissão para efetuar transferência.');
            }

            //Check if the Payee is correct
            $payeeValidate = $this->checkPayeeData($payee);
            if (!$payeeValidate) {
                throw new \RuntimeException('Cadastro não localizado em nosso sistema.');
            }

            //Check if the Payer has balance to transfer
            $payerHasBalance = $this->userHasBalanceEnough($payer, $value);
            if (!$payerHasBalance) {
                throw new \RuntimeException('Não existe saldo suficiente para realizar a transferência.');
            }

            return true;
        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function checkPayerData(int $payer): bool
    {
        //Check if the Payer is correct
        $payerValidate = $this->userService->checkIfUserIsValid($payer);
        if (!$payerValidate) {
            return false;
        }

        $payerAbleTransfer = $this->userService->checkIfUserCanTransferValue($payerValidate);
        return $payerAbleTransfer;
    }

    public function checkPayeeData(int $payee): bool
    {
        //Check if the Payee is correct
        $payerValidate = $this->userService->checkIfUserIsValid($payee);
        if (!$payerValidate) {
            return false;
        }

        return true;
    }

    public function userHasBalanceEnough(int $payer, float $value): bool
    {
        $userWallet = $this->walletRepository->findByColumn('user_id', $payer)->first();

        if (!$userWallet instanceof Wallet || $userWallet->balance < $value) {
            return false;
        }

        return true;
    }

    public function processTransaction(float $value, User $payer, User $payee)
    {
        try {
            //Get de authorization
            $responseAuthorization = $this->getAuthorization();
            if (!$responseAuthorization) {
                throw new \RuntimeException('Transferência não autorizada.');
            }

            //Process debit on wallet
            $debit = $this->walletService->debit($payer, $value);

            //Process credit on wallet
            $credit = $this->walletService->credit($payee, $value);

            if (!$debit || !$credit) {
                throw new \RuntimeException('Erro ao efetuar o processo de transferência dos valores.');
            }

            $register = $this->registerTransaction($value, $payer, $payee);
            if (!$register instanceof Transaction) {
                throw new \RuntimeException('Erro ao registrar o processo de transferência dos valores.');
            }

            //Send the notification
            $responseNotification = $this->getNotification();
            if (!$responseNotification) {
                throw new \RuntimeException('Erro ao enviar a notificação de transferência.');
            }

            return true;
        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function registerTransaction(float $value, User $payer, User $payee): ?Transaction
    {
        $attributes = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $value
        ];

        return $this->transactionRepository->create($attributes);
    }
}
