<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class AlmaModele implements FromCollection
{
    public $payment_purchase_amount;
    public $payment_installments_count; //nombre fois de paiement
    public $payment_return_url;
    public $payment_shipping_address_first_name;
    public $payment_shipping_address_last_name;
    public $payment_shipping_address_line1;
    public $payment_shipping_address_postal_code;
    public $payment_shipping_address_city;
    public $payment_locale;
    public $payment_origin;
    /** */
    public $payment_ipn_callback_url; // url de sécoure
    public $payment_merchant_name; // nom de marchand ayant créé le paiement
    /** */
    public $payment_custom_data;
    /** */
    public $orders_merchant_reference;
    public $orders_merchant_url;
    public $orders_data;
    /** */
    public $customer_first_name;
    public $customer_last_name;
    public $customer_email;
    public $customer_phone;
    /** */
    public $customer_fee; // frais payé par le client appart montant
    public $customer_interest; // intéret payé par le client appart montant
    public $customer_cancel_url; //Url permettant au client d'annuler son paiement et de revenir au site marchand

    public function getPayload()
    {
        $data = [
            "payment" => [
                "purchase_amount" => $this->payment_purchase_amount,
                "installments_count" => $this->payment_installments_count,
                "return_url" => $this->payment_return_url,
                "customer_cancel_url" => $this->customer_cancel_url,
                "shipping_address" => [
                    "first_name" => $this->payment_shipping_address_first_name,
                    "last_name" => $this->payment_shipping_address_last_name,
                    "email" => $this->customer_email,
                    "line1" => $this->payment_shipping_address_line1,
                    "postal_code" => $this->payment_shipping_address_postal_code,
                    "city" => $this->payment_shipping_address_city,
                    "country" => $this->payment_shipping_address_city,
                    "phone" => $this->customer_phone,
                ],
                "billing_address" => [
                    "first_name" => $this->payment_shipping_address_first_name,
                    "last_name" => $this->payment_shipping_address_last_name,
                    "email" => $this->customer_email,
                    "line1" => $this->payment_shipping_address_line1,
                    "postal_code" => $this->payment_shipping_address_postal_code,
                    "city" => $this->payment_shipping_address_city,
                    "country" => $this->payment_shipping_address_city,
                    "phone" => $this->customer_phone,
                ],
                "locale" => $this->payment_locale,
                "origin" => $this->payment_origin,
                "ipn_callback_url" =>  $this->payment_ipn_callback_url, // url de sécoure
                "merchant_name" => $this->payment_merchant_name, // nom de marchand ayant créé le paiement
                /** */
                "custom_data" => $this->payment_custom_data,
            ],
            "orders" => [
                [

                    "merchant_reference" => $this->orders_merchant_reference,
                    "merchant_url" => $this->orders_merchant_url,
                    "data" => $this->orders_data,
                ]
            ],
            "customer" => [
                "first_name" => $this->customer_first_name,
                "last_name" => $this->customer_last_name,
                "email" => $this->customer_email,
                "phone" => $this->customer_phone,
                "addresses" => [
                    [
                        "first_name" => $this->payment_shipping_address_first_name,
                        "last_name" => $this->payment_shipping_address_last_name,
                        "email" => $this->customer_email,
                        "line1" => $this->payment_shipping_address_line1,
                        "postal_code" => $this->payment_shipping_address_postal_code,
                        "city" => $this->payment_shipping_address_city,
                        "country" => $this->payment_shipping_address_city,
                        "phone" => $this->customer_phone,
                    ]
                ]
            ],
        ];
        return collect($data)->toJson();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }
}
