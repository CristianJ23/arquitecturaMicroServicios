<?php

namespace App\Http\Controllers;

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
    public function processPayment(Request $request)
    {
        return $this->successResponse($this->paymentService->processPayment($request->all()));
    }

    /**
     * Get payment status by ID.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayment($id)
    {
        return $this->successResponse($this->paymentService->getPayment($id));
    }

    /**
     * Get payments for a specific order.
     * @param int $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentsByOrder($order_id)
    {
        return $this->successResponse($this->paymentService->getPaymentsByOrder($order_id));
    }

    /**
     * Process a refund for a payment.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function processRefund($id)
    {
        return $this->successResponse($this->paymentService->processRefund($id));
    }

    /**
     * Get payment history for a user.
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentsByUser($user_id)
    {
        return $this->successResponse($this->paymentService->getPaymentsByUser($user_id));
    }
}
