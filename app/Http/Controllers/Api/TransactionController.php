<?php

namespace App\Http\Controllers\Api;


use App\Factory\TransactionFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionWithAuthenticationRequest;
use App\Jobs\TransactionJob;
use App\Services\TransactionService;
use App\Services\UserService;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="localhost:8083",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Backend Challenge",
 *         description="The purpose of this application is transfer value between 2 users.",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="rro.oliveira@gmail.com"
 *         )
 *     )
 * )
 */
class TransactionController extends Controller
{
    protected $transactionService;
    protected $userService;

    public function __construct(TransactionService $transactionService, UserService $userService)
    {
        $this->transactionService = $transactionService;
        $this->userService = $userService;
    }

    /**
     * @SWG\Post (
     *     path="/api/transaction",
     *     summary="Efetua a transferência de valores entre 2 usuários.",
     *     @SWG\Response(response=200, description="Transferência efetuada com sucesso."),
     *     @SWG\Response(response=400, description="
     *                                              Não é permitido efetuar a transfêrencia para o mesmo usuário.
     *                                              Não existe saldo suficiente para realizar a transferência.
     *                                              Cadastro não localizado em nosso sistema ou não tem permissão para efetuar transferência.
     *                                              Cadastro não localizado em nosso sistema.
     *                                              Não existe saldo suficiente para realizar a transferência.
     *                                              Transferência não autorizada.
     *                                              Erro ao registrar o processo de transferência dos valores.
     *                                              Erro ao enviar a notificação de transferência."),
     *          @SWG\Parameter (
     *              description="Valor a ser transferido (Formato americano 1000.00)",
     *              name="value",
     *              in="query",
     *              required=true,
     *              type="string"
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Pagador)",
     *              name="payer",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Beneficiário)",
     *              name="payee",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     * )
     */
    public function transaction(TransactionRequest $request)
    {
        $request->only('value', 'payer', 'payee');
        $data = $request->validated();

        $transaction = $this->transactionService->makeTransaction($data['value'], $data['payer'], $data['payee']);

        if ($transaction instanceof \RuntimeException) {
            return response()->json(['message' => $transaction->getMessage()], 400);
        }
        return response()->json(['message' => 'Transferência efetuada com sucesso.'], 200);
    }

    /**
     * @SWG\Post (
     *     path="/api/transaction-queue",
     *     summary="Efetua a transferência de valores entre 2 usuários utilizando fila de processamento.",
     *     @SWG\Response(response=200, description="Transferência efetuada com sucesso."),
     *     @SWG\Response(response=400, description="
     *                                              Não é permitido efetuar a transfêrencia para o mesmo usuário.
     *                                              Não existe saldo suficiente para realizar a transferência.
     *                                              Cadastro não localizado em nosso sistema ou não tem permissão para efetuar transferência.
     *                                              Cadastro não localizado em nosso sistema.
     *                                              Não existe saldo suficiente para realizar a transferência.
     *                                              Transferência não autorizada.
     *                                              Erro ao registrar o processo de transferência dos valores.
     *                                              Erro ao enviar a notificação de transferência."),
     *          @SWG\Parameter (
     *              description="Valor a ser transferido (Formato americano 1000.00)",
     *              name="value",
     *              in="query",
     *              required=true,
     *              type="string"
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Pagador)",
     *              name="payer",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Beneficiário)",
     *              name="payee",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     * )
     */
    public function transactionQueue(TransactionRequest $request)
    {
        $request->only('value', 'payer', 'payee');
        $data = $request->validated();

        TransactionJob::dispatch($data['value'], $data['payer'], $data['payee']);
    }

    /**
     * @SWG\Post (
     *     path="/api/transaction-with-authentication",
     *     summary="Efetua a transferência de valores entre 2 usuários. O pagador será o usuário logado na aplicação.",
     *     @SWG\Response(response=200, description="Sem resposta de retorno."),
     *          @SWG\Parameter (
     *              description="Valor a ser transferido (Formato americano 1000.00)",
     *              name="value",
     *              in="query",
     *              required=true,
     *              type="string"
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Beneficiário)",
     *              name="payee",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     * )
     */
    public function transactionWithAuthentication(TransactionWithAuthenticationRequest $request)
    {
        $request->only('value', 'payee');
        $data = $request->validated();

        $transaction = $this->transactionService->makeTransaction($data['value'], auth()->id(), $data['payee']);

        if ($transaction instanceof \RuntimeException) {
            return response()->json(['message' => $transaction->getMessage()], 400);
        }
        return response()->json(['message' => 'Transferência efetuada com sucesso.'], 200);
    }

    /**
     * @SWG\Post (
     *     path="/api/transaction-queue-with-authentication",
     *     summary="Efetua a transferência de valores entre 2  utilizando fila de processamento. O pagador será o usuário logado na aplicação.",
     *     @SWG\Response(response=200, description="Sem resposta de retorno."),
     *          @SWG\Parameter (
     *              description="Valor a ser transferido (Formato americano 1000.00)",
     *              name="value",
     *              in="query",
     *              required=true,
     *              type="string"
     *          ),
     *          @SWG\Parameter (
     *              description="Código do usuário (Beneficiário)",
     *              name="payee",
     *              in="query",
     *              required=true,
     *              type="number",
     *          ),
     * )
     */
    public function transactionQueueWithAuthentication(TransactionWithAuthenticationRequest $request)
    {
        $request->only('value', 'payee');
        $data = $request->validated();

        TransactionJob::dispatch($data['value'], auth()->id(), $data['payee']);
    }
}
