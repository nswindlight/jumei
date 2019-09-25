<?php
namespace nswindlight\jumei;

use nswindlight\jumei\ht\Order;

class Jumei{
    public function getHtOrder($client_id,$client_key,$sing){
        return new Order($client_id,$client_key,$sing);
    }
}