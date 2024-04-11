<?php

namespace common\components;

use common\models\BillingInformation;
use common\models\ShippingInformation;

class AddressHelper
{
    public static function isEmpty(BillingInformation|ShippingInformation $object): bool
    {
        foreach ($object->attributes as $index => $attribute) {
            if (!isset($attribute)) {
                return true;
            }
        }
        return false;
    }
}