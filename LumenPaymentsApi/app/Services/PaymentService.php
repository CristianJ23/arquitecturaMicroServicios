<?php

namespace App\Services;

use App\Payment;

class PaymentService
{
    /**
     * Process a payment.
     * @param array $data
     * @return Payment
     */
    public function processPayment(array $data)
    {
        // In a real application, you would integrate with a payment gateway here.
        // For this example, we'll just create a payment record.

        $data['status'] = 'completed'; // Simulate a successful payment
        $data['transaction_id'] = 'txn_' . uniqid();

        return Payment::create($data);
    }

    /**
     * Get a payment by ID.
     * @param int $id
     * @return Payment|null
     */
    public function getPayment($id)
    {
        return Payment::find($id);
    }

    /**
     * Get payments for a specific order.
     * @param int $order_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaymentsByOrder($order_id)
    {
        return Payment::where('order_id', $order_id)->get();
    }

    /**
     * Process a refund for a payment.
     * @param int $id
     * @return Payment|null
     */
    public function processRefund($id)
    {
        $payment = $this->getPayment($id);

        if ($payment) {
            // In a real application, you would refund through the payment gateway.
            $payment->status = 'refunded';
            $payment->save();
        }

        return $payment;
    }

    /**
     * Get payment history for a user.
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaymentsByUser($user_id)
    {
        return Payment::where('user_id', $user_id)->get();
    }
}
