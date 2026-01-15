<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Services\PaymentService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the payments microservice
     * @var PaymentService
     */
    public $paymentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Process a payment.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
        ];

        $this->validate($request, $rules);

        $payment = $this->paymentService->processPayment($request->all());

        return $this->successResponse($payment, Response::HTTP_CREATED);
    }

    /**
     * Get payment status by ID.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payment = $this->paymentService->getPayment($id);

        if (!$payment) {
            return $this->errorResponse('Payment not found', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse($payment);
    }

    /**
     * Get payments for a specific order.
     * @param int $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByOrder($order_id)
    {
        $payments = $this->paymentService->getPaymentsByOrder($order_id);

        return $this->successResponse($payments);
    }

    /**
     * Process a refund for a payment.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function refund($id)
    {
        $payment = $this->paymentService->processRefund($id);

        if (!$payment) {
            return $this->errorResponse('Payment not found or cannot be refunded', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse($payment);
    }

    /**
     * Get payment history for a user.
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUser($user_id)
    {
        $payments = $this->paymentService->getPaymentsByUser($user_id);

        return $this->successResponse($payments);
    }
}
