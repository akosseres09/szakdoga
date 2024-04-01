<?php

namespace common\components;

use Stripe\Stripe;
use yii\base\Component;

class StripeComponent extends Component
{
    public string $secretKey;
    public string $publicKey;

    public function init(): void
    {
        parent::init();
        Stripe::setApiKey($this->secretKey);
    }

}