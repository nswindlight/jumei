<?php
namespace  nswindlight\jumei\ht;

class Common{
    /*
     * [
     *  'client_id'=>'123',
     *  'client_ke'=>'jasldj2jeljwd102j12p912',
     *  'sign'=>'',
     * ]
     */
    protected $client_id;
    protected $client_key;
    protected $sing;
    public function __construct($client_id,$client_key,$sing)
    {
        $this->client_id = $client_id;
        $this->client_key = $client_key;
        $this->sing = $sing;
    }

    public function generateSign($params) {
        if(!$params || empty($this->sing)) return false;
        //所有请求参数按照字母先后顺序排序
        ksort($params);
        // 定义字符串开始 结尾所包括的字符串
        $stringToBeSigned = $this->sing;
        //把所有参数名和参数值串在一起
        foreach ($params as $k => $v) {
            $stringToBeSigned .= "$k$v";
        }
        unset($k, $v);
        // 把 secret_key 夹在字符串的两端
        $stringToBeSigned .= $secret_key;
        // 使用 MD5 进行加密,再转化成大写
         return strtoupper(md5($stringToBeSigned));
    }
    public function curl($url, $postFields = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, $url);

        //https 请求
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v) {
                if ("@" != substr($v, 0, 1))//判断是不是文件上传
                {
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                } else//文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
            }
        }
        $reponse = curl_exec($ch);

        curl_close($ch);

        $encode = mb_detect_encoding($reponse, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
        return iconv($encode, 'UTF-8', $reponse);
    }
}
