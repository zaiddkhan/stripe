<?php
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient('sk_test_51MaL6pSEfjueS3xIMQ6M4e5HfDZlKloQTqIFkQFBrmI3c9sC3xgsZrVe9sh95LCqmQMG7YGFGAIAbfqFhAS0A1Ur00ttVvB0gZ');

// Use an existing Customer ID if this is a returning customer.
$customer = $stripe->customers->create(
    [
        'name' => 'Shruti',
        'address' => [
            'line1' => 'demo',
            'postal_code' => '400058',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'country' => "IND",
        ]

    ]
);
$ephemeralKey = $stripe->ephemeralKeys->create([
  'customer' => $customer->id,
], [
  'stripe_version' => '2022-08-01',
]);
$paymentIntent = $stripe->paymentIntents->create([
  'amount' => 150,
  'currency' => 'inr',
  'description' => "Payment for prescription",
  'customer' => $customer->id,
  'automatic_payment_methods' => [
    'enabled' => 'true',
  ],
]);

echo json_encode(
  [
    'paymentIntent' => $paymentIntent->client_secret,
    'ephemeralKey' => $ephemeralKey->secret,
    'customer' => $customer->id,
    'publishableKey' => 'pk_test_51MaL6pSEfjueS3xIisW5Szo844DimyjzpNmxqN3P63Q3e0dNsSQRi84YQYOijzPKORduyB1YI6D5r5IwLWbMS5oW00GKaT9q2y'
  ]
);
http_response_code(200);