<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/15
 * Time: 14:37
 */

namespace app\admin\controller;


class Duanxin
{
    public  function index(){
         return view();
    }

    public function fa(){
        $mobile = I('mobile');
        $app_key = "23633006";
        $app_secret = "78adcee0de33d605a29885b107ae0b67";
        $SignName="外贸业务员培训";
        $TemplateCode="SMS_60110291";
        $product = "外贸业务员网站";
        $result = $this->duanxin($mobile,$app_key,$app_secret,$SignName,$TemplateCode,$product);
    }

    //手机短信验证码
    public function duanxin($phone,$app_key,$app_secret,$SignName,$TemplateCode,$product){

        $rand_number = $this ->rand_number(6);
        $app_key = $app_key;
        $app_secret = $app_secret;
        $request_paras = array(
            'ParamString' => '{"code":"'.$rand_number.'","product":"'.$product.'"}',
            'RecNum' => $phone,
            'SignName' => $SignName,
            'TemplateCode' => $TemplateCode
        );

        $request_host = "http://sms.market.alicloudapi.com";
        $request_uri = "/singleSendSms";
        $request_method = "GET";
        $info = "";
        $content = $this -> do_get($app_key, $app_secret, $request_host, $request_uri, $request_method, $request_paras, $info);
        return json_decode($content);

    }



    //手机发送短信验证码接口函数
    function do_get($app_key, $app_secret, $request_host, $request_uri, $request_method, $request_paras, &$info) {
        ksort($request_paras);
        $request_header_accept = "application/json;charset=utf-8";
        $content_type = "";
        $headers = array(
            'X-Ca-Key' => $app_key,
            'Accept' => $request_header_accept
        );
        ksort($headers);
        $header_str = "";
        $header_ignore_list = array('X-CA-SIGNATURE', 'X-CA-SIGNATURE-HEADERS', 'ACCEPT', 'CONTENT-MD5', 'CONTENT-TYPE', 'DATE');
        $sig_header = array();
        foreach($headers as $k => $v) {
            if(in_array(strtoupper($k), $header_ignore_list)) {
                continue;
            }
            $header_str .= $k . ':' . $v . "\n";
            array_push($sig_header, $k);
        }
        $url_str = $request_uri;
        $para_array = array();
        foreach($request_paras as $k => $v) {
            array_push($para_array, $k .'='. $v);
        }
        if(!empty($para_array)) {
            $url_str .= '?' . join('&', $para_array);
        }
        $content_md5 = "";
        $date = "";
        $sign_str = "";
        $sign_str .= $request_method ."\n";
        $sign_str .= $request_header_accept."\n";
        $sign_str .= $content_md5."\n";
        $sign_str .= "\n";
        $sign_str .= $date."\n";
        $sign_str .= $header_str;
        $sign_str .= $url_str;

        $sign = base64_encode(hash_hmac('sha256', $sign_str, $app_secret, true));
        $headers['X-Ca-Signature'] = $sign;
        $headers['X-Ca-Signature-Headers'] = join(',', $sig_header);
        $request_header = array();
        foreach($headers as $k => $v) {
            array_push($request_header, $k .': ' . $v);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $request_host . $url_str);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $ret;
    }
}