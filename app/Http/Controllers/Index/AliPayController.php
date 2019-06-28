<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BasicController;
use App\Http\Model\Cart;
use App\Http\Model\Order;
use App\Http\Model\OrderDetail;
use DB;

class AliPayController extends BasicController
{
    public $cart_table; 
    public $order_table;
    public $order_detail_table;
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = '';  //路径
    public $aliPubKey = '';  //路径
    public $privateKey = 'MIIEowIBAAKCAQEAm5kw4eTAhVGlDOMvj6e9o+DSzBmSINYMebDJ8vgjz7GKep5Y0b6bCTqr20CXLaETxmYpR2gKqM9pAp8cYlTxSQxLLsaO1F892V9GNcttNHZZdzPpWKWoSqcQEvUhhgxP15JnCAs9+SU3es4t9ZcO7LM/Iu+A5KpPKnBVgTR5DyrF+EljHiAG5RF0YyQaecDhzLfuoYXb3d9v9UwF3u15ldWgspM3ZKpLYilVViZYuvJoY/ocbh2FRLNVgaxI/SnBF/5d75AwInhLajubusiPuTlYb3742aGO/XRdC4geqmU1YmBlnxt+UXUrlbFqVv40hDLljhHPVGrtDv4WH0xEMQIDAQABAoIBAA+eFqv1u+Ulxr0+aF2w5nX2cPIPdv1YvrPQLNT4Vw/XsCCSmDOlQAZzHyDIoOPxkPyO8IG8TaWX++BJfB3ajMVaOImfYGKslJam23M20eU8I8q1KSy+o9+qWRCuDglYXwMyLKlAB55kP+dRnodR/CuB6kplY7iP55ZI5CwtyiDdcCBgOXNlzPt5mDOjlzAvm9KlmTB7DTcX7c2jnx1gHW20R37u8C+0xFzWuq8unPYfnzoQUHbFiMqONaQuW1aSUH+eQZ1mK/sP3G+hY2ZI8G7uk3932/vCnUYbla/Iz0O4xp+P0vf72aeUUwRHBqJjK3uvZwZVHQpLhe1ugJBqsuECgYEAzYXvK/bA2uwOqA/JSQHzhiDqFCt+9G0OqE+DD3gtDUS7ol0EyIlWd5SKWXVjBRl2Jr3nBCyZDCt7uTMgDwxq7Or9KXHg5DAB6nV8TjrkzlEYPbRfJpnSmQLehDif+lUeYHvc+kuTV8wmIBe8r59ZCoFNZewp9Xpml2k1xBGI1n0CgYEAwdBJLSC1AlvqwnhpkyFzsQvgEruaLhwCK5rVJz46v69y/YI3hn5a6F32fT5ZJ2RIwTudJ2Q7Zx11j0sLlVxTw4WNQqudpvdfR/2gmHe0K5Q4+6xIZQ+u2j3NMiAZmrMk9bvXncVfdOxJGzD5rOKyFvx6wkUK+qStiiYxobij7sUCgYEAoMkCNqvBbsO0J6jJ+RLMuIcxeXwZwxE6oVQrHUQQQswd2sTYxCYlfkG4Bop+X/PuahqxC6P0TAAMt/OWRg+Z6yVfzzenD/260fj9uZn7fKkWxNdChUlb55bGDDzccxR6QlNEqo/LgqlUvlCzrdWE7GIB8hXTMZeDgTqu9GgfXGUCgYA7q3WsCCLSXBw1zT6rxqPIwWA2RD3erk7Yv+2aDGWn+EtN01Zm+OXiHnOx8Y0fPJfNrh3fL9O+FmrIOBGT5X4Ad1CbUxzRd92E24gjCM+WjybQDSWov6BUnqxbH1jisP7TDQcAEvElnU2Qqo5j9NNhkk/1Ga6cpjCrlMC5CpCmBQKBgCNSi0MFvIGqi+SDqLoY1Ch1KtgYweOj47gaWLR72EaLqGZec77By5Pacfe8EtxRZ8L/gzN2ps5gRTahnYx9iYFxKZFCY2+g7MrfbADp2k28ERl5ce/wGcI9qy1mP0CDhkQMsCCdPGHwD6K44SUgzy95SvvcHRzi8kd1j0q/OEmn';
    public $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAm5kw4eTAhVGlDOMvj6e9o+DSzBmSINYMebDJ8vgjz7GKep5Y0b6bCTqr20CXLaETxmYpR2gKqM9pAp8cYlTxSQxLLsaO1F892V9GNcttNHZZdzPpWKWoSqcQEvUhhgxP15JnCAs9+SU3es4t9ZcO7LM/Iu+A5KpPKnBVgTR5DyrF+EljHiAG5RF0YyQaecDhzLfuoYXb3d9v9UwF3u15ldWgspM3ZKpLYilVViZYuvJoY/ocbh2FRLNVgaxI/SnBF/5d75AwInhLajubusiPuTlYb3742aGO/XRdC4geqmU1YmBlnxt+UXUrlbFqVv40hDLljhHPVGrtDv4WH0xEMQIDAQAB';
    public function __construct(Cart $cart,Order $order,OrderDetail $orderDetail)
    {
        $this->cart_table = $cart;
        $this->order_table = $order;
        $this->order_detail_table = $orderDetail;
        $this->app_id = '2016092800618146';
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('APP_URL').'/notify_url';
        $this->return_url = env('APP_URL').'/return_url';
    }
    /**
     * 确认订单
     * [confirm_pay description]
     * @return [type] [description]
     */
    public function confirm_pay(){
        
        $cart_info = $this->cart_table->where(['uid'=>session('user_id')])->get();
        $total = 0;
        foreach($cart_info->toArray() as $v){
            $total += $v['goods_price'];
        }
        return view('home.confirm_pay',['cart_info'=>$cart_info,'total'=>$total]);
    }
    /*
     * 根据订单号支付订单
     */
    public function pay_order(Request $request){
        $req = $request->all();
        if(empty($req['oid'])){
            echo "参数错误!";
            die();
        }
        $this->ali_pay($req['oid']);
    }
    
    
    /**
     * 订单支付
     * @param $oid
     */
    public function pay()
    {
        //生成订单信息
        //货物信息
        DB::connection('mysql_shop')->beginTransaction(); //开启事务
        $cart_info = $this->cart_table->where(['uid'=>session('user_id')])->get();
        if(empty($cart_info)){
            echo "购物车为空！";
            die();
        }
        $total = 0;
        foreach($cart_info->toArray() as $v){
            $total += $v['goods_price'];
        }
        $oid = time().mt_rand(1000,1111);  //订单编号
        $order_result = $this->order_table->insert([
            'oid'=>$oid,
            'uid'=>session('user_id'),
            'pay_money'=>$total,
            'add_time'=>time()
        ]);
        $order_detali_result = true;
        foreach($cart_info->toArray() as $v){
            $detail_result = $this->order_detail_table->insert([
                'oid'=>$oid,
                'goods_id'=>$v['goods_id'],
                'goods_name'=>$v['goods_name'],
                'goods_pic'=>$v['goods_pic'],
                'add_time'=>time()
            ]);
            if(!$detail_result){
                $order_detali_result = false;
                break;
            }
        }

        if(!$order_detali_result || !$order_result){
             DB::connection('mysql_shop')->rollBack();
            die('操作失败!');
        }

        DB::connection('mysql_shop')->commit();
        $this->ali_pay($oid);
    	
    }
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
    	if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
    		$priKey=$this->privateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
    	}else{
    		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
    	}
        
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }
    /**
     * 根据订单号支付
     * [ali_pay description]
     * @param  [type] $oid [description]
     * @return [type]      [description]
     */
    public function ali_pay($oid){
        $order = $this->order_table->where(['oid'=>$oid,'state'=>1])->select(['pay_money'])->first();
        if(empty($order)){
            echo "订单不存在!";
            die();
        }
        $order_info = $order->toArray();
        //业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$oid,
            'out_trade_no'      => $oid,
            'total_amount'      => $order_info['pay_money'],
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.page.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        
        header("Location:".$url);
    }

    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
        header('Refresh:2;url=/order_list');
        echo "<h2>订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转</h2>';
    }
    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {
        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                DB::connection('mysql_shop')->beginTransaction(); //开启事务
                //更新订单状态
                $oid = $_POST['out_trade_no'];     //商户订单号
                $info = [
                    'pay_time'      => strtotime($_POST['gmt_payment']), //支付时间
                    'state'         => 2
                ];
                $order_result = $this->order_table->where(['oid'=>$oid])->update($info);
                
                //清理购物车
                $order_detail_info = $this->order_detail_table->where(['oid'=>$oid])->select(['goods_id'])->get()->toArray();
                $goods_list = [];
                foreach($order_detail_info as $v){
                    $goods_list[] = $v['goods_id'];
                }
                $cart_result = $this->cart_table->whereIn('goods_id',$goods_list)->delete();
                
                if($cart_result && $order_result){
                    DB::connection('mysql_shop')->commit();
                }else{
                    file_put_contents(storage_path('logs/alipay.log'),'订单：'.$oid."；支付失败",FILE_APPEND);
                    DB::connection('mysql_shop')->rollBack();
                }
            }
        }
        
        echo 'success';
    }
    //验签
    function verify($params) {
        $sign = $params['sign'];

        if($this->checkEmpty($this->aliPubKey)){
            $pubKey= $this->publicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($this->aliPubKey);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        
        
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        
        if(!$this->checkEmpty($this->aliPubKey)){
            openssl_free_key($res);
        }
        return $result;
    }
    
}
