<?php


namespace app\api\service;

class Dama
{
    public $app_id = "319711";
    public $app_key = "VoLdvhx3PA6Q9d6TWYD/yZR+wj1cpZtz";
    public $pd_id = "119711";
    public $pd_key = "i2/GGELrkcULHfvP10sU8/XfgL4zQFql";
    public $host = "http://pred.fateadm.com";

    public function GetSign($pd_id, $pd_key, $timestamp)
    {
        $chk_sign1 = md5($timestamp . $pd_key);
        $chk_sign2 = md5($pd_id . $timestamp . $chk_sign1);
        return $chk_sign2;
    }

    public function GetCardSign($cardid, $cardkey, $timestamp, $pdkey)
    {
        $sign = md5($pdkey . $timestamp . $cardid . $cardkey);
        return $sign;
    }

    public function Post($url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);    //设置本机的post请求超时时间
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function ArrayToPostData($data)
    {
        $post_data = "";
        $first_flag = true;
        foreach ($data as $key => $val) {
            if ($first_flag == true) {
                $first_flag = false;
            } else {
                $post_data = $post_data . "&";
            }
            $post_data = $post_data . $key . "=" . $val;
        }
        return $post_data;
    }

    public function MFormPost($url, $post_data, $img_data)
    {
        $uniq_id = uniqid();
        $upload_data = $this->ArrayToMFormData($post_data, $img_data, $uniq_id);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);    //设置本机的post请求超时时间
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $upload_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: multipart/form-data; boundary=" . $uniq_id,
            "Content-Length: " . strlen($upload_data)
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
//        echo $upload_data;
    }

    public function ArrayToMFormData($post_data, $file, $uniq_id)
    {
        $data = "";
        //拼接报头
        foreach ($post_data as $key => $val) {
            $data .= "--" . $uniq_id . "\r\n"
                . 'Content-Disposition: form-data; name="' . $key . "\"\r\n\r\n"
                . $val . "\r\n";
        }
        //拼接文件
        $data .= "--" . $uniq_id . "\r\n"
            . 'Content-Disposition: form-data; name="img_data"; filename="' . "img_data" . "\"\r\n"
            . 'Content-Type:application/octet-stream' . "\r\n\r\n";
        $data .= $file . "\r\n";
        $data .= "--" . $uniq_id . "--\r\n";
        return $data;
    }

    /**
     * 识别验证码
     * 参数： $predict_type：识别类型, $img_data：要识别的图片数据
     * 返回值：
     *      $json_rsp->RetCode：正常时返回0
     *      $json_rsp->ErrMsg：异常时显示异常详情
     *      $json_rsp->RequestId：唯一的订单号
     *      $json_rsp->rsp->result：识别结果
     */
    public function Predict($predict_type, $img_data)
    {
        $timestamp = time();
        $sign = $this->GetSign($this->pd_id, $this->pd_key, $timestamp);
        $data = array(
            'user_id' => $this->pd_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'predict_type' => $predict_type,
            'up_type' => "mt"
        );
        if ($this->app_id != "") {
            $asign = $this->GetSign($this->app_id, $this->app_key, $timestamp);
            $data["appid"] = $this->app_id;
            $data["asign"] = $asign;
        }
        $url = $this->host . "/api/capreg";
        $rsp = $this->MFormPost($url, $data, $img_data);
        $json_rsp = json_decode($rsp);
        if ($json_rsp->RetCode == 0) {
            $result = json_decode($json_rsp->RspData);
            $json_rsp->rsp = $result;
        }
        return $json_rsp;
    }

    /**
     * 识别失败，进行退款请求
     * 参数：$request_id：需要退款的订单号
     * 返回值：
     *      $json_rsp->RetCode：正常时返回0
     *      $json_rsp->ErrMsg：异常时显示异常详情
     *
     * 注意：
     *      Predict识别接口，仅在ret_code == 0 时才会进行扣款，才需要进行退款请求，否则无需进行退款操作
     * 注意2：
     *      退款仅在正常识别出结果后，无法通过网站验证的情况，请勿非法或者滥用，否则可能进行封号处理
     */
    public function Justice($request_id)
    {
        $timestamp = time();
        $sign = $this->GetSign($this->pd_id, $this->pd_key, $timestamp);
        $data = array(
            'user_id' => $this->pd_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'request_id' => $request_id,
        );
        $url = $this->host . "/api/capjust";
        $post_data = $this->ArrayToPostData($data);
        $rsp = $this->Post($url, $post_data);
        $json_rsp = json_decode($rsp);
        return $json_rsp;
    }

    /**
     * 查询余额
     * 参数：无
     * 返回值：
     *      $json_rsp->RetCode：正常时返回0
     *      $json_rsp->ErrMsg：异常时显示异常详情
     *      $json_rsp->cust_val：用户余额
     */
    public function QueryBalanc()
    {
        $timestamp = time();
        $sign = $this->GetSign($this->pd_id, $this->pd_key, $timestamp);
        $data = array(
            'user_id' => $this->pd_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
        );
        $url = $this->host . "/api/custval";
        $post_data = $this->ArrayToPostData($data);
        $rsp = $this->Post($url, $post_data);
        $json_rsp = json_decode($rsp);
        return $json_rsp;
    }

    /**
     * 充值接口
     * 参数：$cardid：充值卡号, $cardkey：充值卡签名串
     * 返回值：
     *      $json_rsp->RetCode：正常时返回0
     *      $json_rsp->ErrMsg：异常时显示异常详情
     */
    public function Charge($cardid, $cardkey)
    {
        $timestamp = time();
        $sign = GetSign($this->pd_id, $this->pd_key, $timestamp);
        $csign = GetCardSign($cardid, $cardkey, $timestamp, $this->pd_key);
        $data = array(
            'user_id' => $this->pd_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'cardid' => $cardid,
            'csign' => $csign,
        );
        $url = $this->host . "/api/charge";
        $post_data = ArrayToPostData($data);
        $rsp = Post($url, $post_data);
        $json_rsp = json_decode($rsp);
        return $json_rsp;
    }

    /**
     * 查询网络延迟
     * 参数： $predict_type:识别类型
     * 返回值：
     *      $json_rsp->RetCode：正常时返回0
     *      $json_rsp->ErrMsg：异常时显示异常详情
     */
    public function RTT($predict_type)
    {
        $timestamp = time();
        $sign = GetSign($this->pd_id, $this->pd_key, $timestamp);
        $data = array(
            'user_id' => $this->pd_id,
            'timestamp' => $timestamp,
            'sign' => $sign,
            'predict_type' => $predict_type,
        );
        if ($this->app_id != "") {
            $asing = GetSign($this->app_id, $this->app_key, $timestamp);
            $data["appid"] = $this->app_id;
            $data["asign"] = $asing;
        }
        $url = $this->host . "/api/qcrtt";
        $post_data = ArrayToPostData($data);
        $rsp = Post($url, $post_data);
        $json_rsp = json_decode($rsp);
        if ($json_rsp->RetCode == 0) {
            $result = json_decode($json_rsp->RspData);
            $json_rsp->rsp = $result;
        }
        return $json_rsp;
    }

    /***
     * 余额查询,只返回余额
     * 参数：无
     * 返回值:用户余额
     */
    public function QueryBalancExtend()
    {
        $rsp = $this->QueryBalanc();
        return json_decode($rsp->RspData)->cust_val;
    }

    /***
     * 充值接口，成功返回0
     * 参数：$cardid：充值卡号, $cardkey：充值卡签名串
     * 返回值： 充值成功返回0
     */
    public function ChargeExtend($cardid, $cardkey)
    {
        $rsp = $this->Charge($cardid, $cardkey);
        return $rsp->RetCode;
    }

    /***
     * 退款接口，成功返回0
     * 参数：$request_id：需要退款的订单号
     * 返回值：退款成功时返回0
     */
    public function JusticeExtend($request_id)
    {
        $rsp = $this->Justice($request_id);
        return $rsp->RetCode;
    }

    /***
     * 识别接口，只返回识别结果
     * 参数： $predict_type：识别类型, $img_data：要识别的图片数据
     * 返回值： 识别的结果
     */
    public function PredictExtend($predict_type, $img_data)
    {
        $rsp = $this->Predict($predict_type, $img_data);
        return json_decode($rsp->RspData)->result;
    }

    public function Test()
    {
        $api = new Dama();
        // 查询余额
        $rsp = $api->QueryBalanc();                 // 查询余额，返回详细的信息
        //        object(stdClass)#38 (4) {
        //            ["RetCode"] => string(1) "0"
        //            ["ErrMsg"] => string(4) "succ"
        //            ["RequestId"] => string(0) ""
        //            ["RspData"] => string(16) "{"cust_val":990}"
        //        }
        if ($rsp->RetCode == '0' && !is_null($rsp->RspData) && json_decode($rsp->RspData)) {
            //获取成功
            $number = json_decode($rsp->RspData)->cust_val;
            if ($number < 100) {
                //发送短信提示积分不够使用了
                halt(1);
            }
        } else {
            //获取失败
            $rsp->ErrMsg;
        }

        // 通过文件进行验证码识别,请使用自己的图片文件替换
        $file_name = 'C:\inetpub\LocalUser\resources\download\images\index.png';
        // 具体类型可以查看官方网站的价格页选择具体的类型，不清楚类型的，可以咨询客服
        $predict_type = 30400;
        $img_data = file_get_contents($file_name);       // 通过文件路径获取图片数据
        // 识别图片：
        // 多网站类型时，需要增加src_url参数，具体请参考api文档: http://docs.fateadm.com/web/#/1?page_id=6
        // echo $api->PredictExtend($predict_type,$img_data);       // 识别接口，只返回识别结果
        $rsp = $api->Predict($predict_type, $img_data);  // 识别接口，返回识别结果的详细信息
        //        object(stdClass)#38 (5) {
        //                ["RetCode"] => string(1) "0"
        //            ["ErrMsg"] => string(0) ""
        //            ["RequestId"] => string(32) "20200114230050e28cf6cf0007294b13"
        //            ["RspData"] => string(18) "{"result": "rwsc"}"
        //            ["rsp"] => object(stdClass)#39 (1) {
        //            ["result"] => string(4) "rwsc"
        //          }
        //        }
        if ($rsp->RetCode == "0" && !is_null($rsp->RspData) && json_decode($rsp->RspData)) {
            //识别成功
            $code = json_decode($rsp->RspData)->result;
        } else {
            //识别失败,退款
            $request_id = $rsp->RequestId;
            $tuikuan_info = $api->Justice($request_id);
            if ($tuikuan_info->RetCode != "0") {
                //退款失败
                halt($tuikuan_info->ErrMsg);
            }
        }

        // 用户可以直接用充值卡充值
        //$cardid         = "08167103";
        //$cardkey        = "dfcea31eff83";
        //$rsp            = $api->Charge( $cardid, $cardkey);
        //var_dump( "<br>charge result: ", $rsp);

        // 可以查询网络服务状况
        //$rsp            = $api->RTT(100010001);
        //var_dump( "<br>rtt result: ", $rsp);
    }
}
