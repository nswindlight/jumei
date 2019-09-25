<?php
namespace  nswindlight\jumei\ht;

class Order extends Common {
    //const apiUrl = 'https://open.int.jumei.com/apiDoc/groups';
    const apiUrl ='http://openapi.ext.jmrd.com:8823';
    /*
     * $param Array
     * start_date String 否 开始时间 格式:YYYY-MM-DD HH:MM:SS
     * end_date String  否 结束时间  格式:YYYY-MM-DD HH:MM:SS
     * status String  是 状态  2:已付款订单,7:备货中订单,这两种状态的订单都是未完成发货的状态,都需要获取。参数传入方式:status=2,7或status=2或status=7
     * shipping_system_id String  否 仓库ID  为空时将获取商家所有仓库订单
     */
    public function getOrderIds($param){
        if(empty($param['status'])) return false;
        $default = ['start_date'=>'','end_date'=>'','shipping_system_id'=>''];
        $param = array_merge($default,$param);

        $param['client_id'] = $this->client_id;
        $param['client_key'] = $this->client_key;
        $param['sign'] = $this->generateSign($param);

        $url = self::apiUrl .'/HtOrder/GetOrderIds?'. http_build_query($param);

        return $this-> curl($url);
    }

    public function getOrderDetailByOrderId($order_id){
        if(!$order_id) return false;
        $param = [];
        $param['order_id'] = $order_id;
        $param['client_id'] = $this->client_id;
        $param['client_key'] = $this->client_key;
        $param['sign'] = $this->generateSign($param);
        $url = self::apiUrl .'/HtOrder/GetOrderIds?'. http_build_query($param);
        return $this-> curl($url);
    }

    public function setShipping($order_id,$logistic_id,$logistic_track_no){
        $param = [];
        $param['order_id'] = $order_id;
        $param['logistic_id'] = $logistic_id;
        $param['logistic_track_no'] = $logistic_track_no;
        $param['client_id'] = $this->client_id;
        $param['client_key'] = $this->client_key;
        $param['sign'] = $this->generateSign($param);

        $url = self::apiUrl .'/HtOrder/GetOrderIds?'. http_build_query($param);
        return $this-> curl($url);
    }
    public function getUndisposedOrder($param){
        if(empty($param['curr_time'])) return false;
        $default = ['page'=>'','page_size'=>''];
        $param = array_merge($default,$param);

        $param['client_id'] = $this->client_id;
        $param['client_key'] = $this->client_key;
        $param['sign'] = $this->generateSign($param);
        $url = self::apiUrl .'/v1/HtOrder/GetUndisposedOrder?'. http_build_query($param);
        return $this-> curl($url);
    }

    public function getExternalBatchNosForMerchant(){

    }

    public function getLogistics($logistic_name = ''){
        $param = [];
        $param['logistic_name'] = $logistic_name;
        $param['client_id'] = $this->client_id;
        $param['client_key'] = $this->client_key;

        $param['sign'] = $this->generateSign($param);
        $url = self::apiUrl .'/HtOrder/GetLogistics?'. http_build_query($param);
        return $this-> curl($url);
    }
}