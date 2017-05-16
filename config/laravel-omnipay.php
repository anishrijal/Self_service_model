<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		]
	],
    'unionpay' => [
        'driver' => 'UnionPay_Express',
        'options' => [
            'merId' => '777290058120462',
            'certPath' => '/path/to/storage/app/unionpay/certs/PM_700000000000001_acp.pfx',
            'certPassword' =>'000000',
            'certDir'=>'/path/to/certs',
            'returnUrl' => '/unionpay/pay',
            'notifyUrl' => '/unionpay/return'
        ]
    ]

];