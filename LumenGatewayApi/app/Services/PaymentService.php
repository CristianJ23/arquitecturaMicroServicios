<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class PaymentService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the payments service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to consume the payments service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.payments.base_uri');
        $this->secret = config('services.payments.secret');
    }

    /**
     * Process a payment.
     * @param array $data
     * @return string
     */
    public function processPayment($data)
    {
        return $this->performRequest('POST', '/payments', $data);
    }

    /**
     * Get a single payment from the payments service
     * @param int $id
     * @return string
     */
    public function getPayment($id)
    {
        return $this->performRequest('GET', "/payments/{$id}");
    }

    /**
     * Get payments for a specific order.
     * @param int $order_id
     * @return string
     */
    public function getPaymentsByOrder($order_id)
    {
        return $this->performRequest('GET', "/payments/order/{$order_id}");
    }

    /**
     * Process a refund for a payment.
     * @param int $id
     * @return string
     */
    public function processRefund($id)
    {
        return $this->performRequest('POST', "/payments/{$id}/refund");
    }

    /**
     * Get payment history for a user.
     * @param int $user_id
     * @return string
     */
    public function getPaymentsByUser($user_id)
    {
        return $this->performRequest('GET', "/payments/user/{$user_id}");
    }
}
