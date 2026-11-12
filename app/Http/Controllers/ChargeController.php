<?php

namespace App\Http\Controllers;

use App\User;
use Nikolag\Square\Facades\Square;
use Nikolag\Square\Models\Customer;

class ChargeController extends Controller
{

    /**
     * Create customer.
     */
    public function createCustomer()
    {
        try {
            $customerArr = [
                'first_name' => 'Nikola',
                'last_name' => 'Gavric',
                'company_name' => 'The Testing Company - TTC',
                'nickname' => 'gavra',
                'email' => 'nikoxxxxxxxx@xxxx.com',
                'phone' => '+38112341251',
                'note' => 'Some small note up to 50 characters.',
            ];

            $customer = new Customer($customerArr);
            $customer->save();

            return response()->json(compact('customer'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Basic charge.
     */
    public function charge()
    {
        try {
            $transaction = Square::charge([
                'amount' => 500,
                'card_nonce' => 'fake-card-nonce-ok',
                'location_id' => 'LPT212K1X254A',
                'currency' => 'USD'
            ]);

            return response()->json(compact('transaction'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Charge the customer.
     */
    public function chargeWithMerchant(User $merchant)
    {
        try {
            $transaction = Square::setMerchant($merchant)
                ->charge([
                    'amount' => 500,
                    'card_nonce' => 'fake-card-nonce-ok',
                    'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                    'currency' => 'USD'
                ]);
            return response()->json(compact('transaction'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Charge with specifying who is the merchant.
     */
    public function chargeWithCustomer(Customer $customer)
    {
        try {
            $transaction = Square::setCustomer($customer)
                ->charge([
                    'amount' => 500,
                    'card_nonce' => 'fake-card-nonce-ok',
                    'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                    'currency' => 'USD'
                ]);
            return response()->json(compact('transaction'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Charge the customer with specifying
     * who is the merchant.
     */
    public function chargeWithMerchantAndCustomer(User $merchant, Customer $customer)
    {
        try {
            $transaction = Square::setMerchant($merchant)
                ->setCustomer($customer)
                ->charge([
                    'amount' => 500,
                    'card_nonce' => 'fake-card-nonce-ok',
                    'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                    'currency' => 'USD'
                ]);

            return response()->json(compact('transaction'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
}
