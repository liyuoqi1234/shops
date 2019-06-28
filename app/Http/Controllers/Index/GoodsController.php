<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GoodsController extends Controller
{
    public function goods()
    {
        $data=DB::table('cart')
            ->join('goods','cart.id','=','goods.id')
            ->get();
            $total = 0;
            foreach($data->toArray() as $v){
                $total += $v->buy_num * $v->goods_mon;
            }
           
        return view('goods.goods',['data'=>$data,'total'=>$total]);
    }

    public function proinfo()
    {
        $id=\request()->id;
        $res = DB::table('goods')->where('id',$id)->get();
        return view('goods.proinfo',['res'=>$res]);
    }

    public function check()
    {
        $id = request()->id;
        $buy_num = request()->buy_num;
        $res = DB::table('goods')->where('id',$id)->get();
        $goods_mon=$res[0]->goods_mon;
        $newprice=$buy_num*$goods_mon;
        return $newprice;
    }

    public function addca()
    {
        $data=request()->input();
        // $where=[
        //     'goods_id'=>$data['goods_id'],
        //     'login_id'=>$data['login_id']
        // ];
        // $count=DB::table('cart')->where($where)->count();
        // if ($count>0){
        //     return ['font'=>'该商品已在购物车内','code'=>2];die;
        // }else{
            $res=DB::table('cart')->insert($data);
            
            if ($res){
                return ['code'=>1];die;
            }else{
                return ['code'=>2];die;
            
        }
    }
    
    public function getSubTotal()
    {
        $num=request()->goods_num;
        $price=request()->price;
        return $newprice=$num*$price;
    }

    public function del($cart_id)
    {
        $res = request()->all();
       $data = DB::table('cart')->where(['cart_id'=>$cart_id])->delete();
     
       if($data){
           return redirect('goods/goods');
       }
    }

    public function order()
    {
        $res = DB::table('order')->first();
        $data=DB::table('cart')
        ->join('goods','cart.id','=','goods.id')
        ->get();
        $total = 0;
        foreach($data->toArray() as $v){
            $total += $v->buy_num * $v->goods_mon;
        }
         // if($data['state'] == 1){
        //     return ['未支付'];
        // }else{
        //     return ['未支付'];
        // }
        // $state = 1;
        // $xb = $state == 1 ? '未支付' : ($state == 2 ? '已支付' : '未知');
        // return $xb;
        // dd($res);
        return view('goods.order',['res'=>$res,'total'=>$total]);
    }

    public function orderadd()
    {
        $res = request()->all();
        $data['end_time'] = time();
        $order_no= time().mt_rand(1000,1111);  //订单编号
        
        $data = DB::table('order')->insert([
            'cart_id'=>$res['cart_id'],
            'end_time'=>time(),
            'order_no'=>$order_no,
        ]);

       
        if($data){
            return(['code'=>1]);
        }else{
            return(['code'=>2]);
        }

    }

    public function dele($order_id){
        $res = DB::table('order')->where(['order_id'=>$order_id])->delete();
        if($res){
            return redirect('goods/goods');
        }
    }
    
        public $app_id;
        public $gate_way;
        public $notify_url;
        public $return_url;
        public $rsaPrivateKeyFilePath = '';  //路径
        public $aliPubKey = '';  //路径
        public $privateKey = "MIIEpAIBAAKCAQEA8m5UCWy/E0aCs7wMyBkshApvd9nPz0AkmlNhFgcy/UI+p4KfklW1CX2Io+MesiXB5N/Fle/fyiCzZ8dUmd5cnFKQA4MCaIUf8O2BWJh8s2dbB6YyWQjYHFL78cJMr7YvFuLYxgXnpU5bwDVtn3JaGW1mAkrr4ubiGWqp4zlro6sV8bU7D8ODlbSS/30HBNfvRdjLXyLon8GaP+3CWPh/K0Hdqh0f2XA7KBpyZKlGhlsD4+xLEUWPrAvM9aKtYo6SN/H3/LBP5iWfgRIyucjBB2ob23OvtZ3QvcpRUwoGCcofnJOeVlx12mU3+xXjZE/vXOF5RTBV1c0FcScmDTTVSwIDAQABAoIBAQDo6b6rX2MkLbYc4CqXhDgUk8IML6NLxqBj9H9uHnSKhT6UyRZuDRHlkEnayrYPCd+C+MpoBxHGrCwxJHzPZ6cqONhLx25k5KGPY1/Fspr78eyvKKluiOS4MbIEz1vF5Q7QuhjyB3JKi0HzJGGxsreFfmlnAnwmfxPyv1uBBwW3MyUry6BsDaSav8SqgNpzQmBawk1FwxASlWP73/Q0TQ4Gn6HmzMT3k0Psqn2gYVZsOhIY3a8vyF3vvUsGhWKkrUn18pJ5kIziHQbmH2J9zTFOlG8pVBFvwarD3QkHZjx78hzsfY3jr7okGO5mlzjmhbu8KbWB3rgCCkkGwwqL3I1BAoGBAPorkQ75Tx9h/dT6CTQKPrTH8bdILJbHmUjxHz1g6oXw2TwR4f4ZOfH+66atyPl7BQTX3ehk5vqmrbX9EMB4h+dKUDnVoMzPslmUoTQ7RP6Hl57/EmJ/J9OwMgLdQpL/bEJhA3KtOmbVjS9oqLneUDhVuEeZOOVngczSeh3x03GzAoGBAPgUl48mBsY8QCL9m3yBtdp4CX3M9oYPGuf/gd7OYguO473yqP257vkx118UkrKRyETN9sVefIxeVKl8yeYblJpLRgQqVV58CgNgtuQgaq944xG2GXjIYOarK6XjvO1x+CZ0nvG1qlqHq1kgOB0PBb1MQfTIp268gsOVy79l+9IJAoGAHB8fnEZMLaPvS6ybsjzglaPQOSEk2gIv6fIo59ZoJoxPbyA3fj/JsrlMNh1c9SZuBwBZEpGdIVnxNv7ujiQ+arKA2C96dut2CfnaMSvkcpQ9aAMWRvoyOOqahJXosOuDeOa843wzj3G8ADNMnDAwZlTEdU/1BFyhS6vxTEJt2V8CgYBK7V1BPQj6wqPUbaiSmFKmo26qckdbAiDsRT2iX885EnUyn6Hu0EOfPDCCZSJRkLpeHZ8UyY7wjmUfs7L/LwFZALcq9uZF3Uzg7EsQ58GRMf/TD57t3gd2Y+iQ+BHN3YhHhR2kf2vuX9+e0Z5hGHJxVCDvn9MCHSmZjRq2ukSukQKBgQDLAkzKt5KM2KpNc4CkrsFzRyu+2o102JhUxunrF7a2b4rQzKXvYQH0uIHSEFM/V/Z6R6PxKhuF0iEViCqAG8SK0wQ5pMj0Jpgo1ZtRjkXG4V4LyoMg4DiA7mpGENL2mrvfKqSsxtsqGToEgTpeXUcsKcK0I9TOklySfaNq+lDa9A==";
        public $publicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuTi4h5PIfBefMe1JCz8sLSnG9O9QDzTPg33xONQXOIjz2+d4byOtjucJRmyKWjDE5uGTwn5I6j2/CqHaPjhavVypU3vuM2G3jxuXFz37pP0YCs52RsEvr22mRtNx6+rkooc6uVVrN6W0mktClTqErGJYUwYyXXc1otr5XXjRrepCASCEZsqLsfguf/DqqBla1f6On+wKs4Rpg8zi5gzvscCjurVO8uQfUVjrckDGYvI6ABkS2pkaNLMIUG1MO6VaOclpDGctoiqUvQ2k5NdBsuuwA9yOSiu36y36VEFIZBA7u+vCBRXToL2NNGAJQG0g1Ekn4F8XgIKWGIQEh67XFQIDAQAB";
        public function __construct()
        {
            $this->app_id = '2016100100636323';
            $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
            $this->notify_url = env('APP_URL').'/notify_url';
            $this->return_url = env('APP_URL').'/return_url';
        }
        
        
        /**
         * 订单支付
         * @param $oid
         */
        public function pay()
        {
            // file_put_contents(storage_path('logs/alipay.log'),"\nqqqq\n",FILE_APPEND);
            // die();
            //验证订单状态 是否已支付 是否是有效订单
            //$order_info = OrderModel::where(['oid'=>$oid])->first()->toArray();
            //判断订单是否已被支付
            // if($order_info['is_pay']==1){
            //     die("订单已支付，请勿重复支付");
            // }
            //判断订单是否已被删除
            // if($order_info['is_delete']==1){
            //     die("订单已被删除，无法支付");
            // }
            $res =DB::table('order')->get();  //订单编
            $oid=0;
            foreach($res->toArray() as $v){
                $oid=$v->order_no;
            }
            $date=DB::table('cart')
            ->join('goods','cart.id','=','goods.id')
            ->get();
            $total= 0;
            foreach($date->toArray() as $v){
                    $total += $v->buy_num * $v->goods_mon;
            }
            //业务参数
            $bizcont = [
                'subject'           => 'Lening-Order: ' . $oid,
                'out_trade_no'      => $oid,
                'total_amount'      => $total,
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
            header('Refresh:2;url=/order/list');
            echo "订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转';
    //        echo '<pre>';print_r($_GET);echo '</pre>';die;
    //        //验签 支付宝的公钥
    //        if(!$this->verify($_GET)){
    //            die('簽名失敗');
    //        }
    //
    //        //验证交易状态
    ////        if($_GET['']){
    ////
    ////        }
    ////
    //
    //        //处理订单逻辑
    //        $this->dealOrder($_GET);
        }
        /**
         * 支付宝异步通知
         */
        public function aliNotify()
        {
            $data = json_encode($_POST);
            $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
            //记录日志
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
            //验签
            $res = $this->verify($_POST);
            $log_str = '>>>> ' . date('Y-m-d H:i:s');
            if($res === false){
                //记录日志 验签失败
                $log_str .= " Sign Failed!<<<<< \n\n";
                file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
            }else{
                $log_str .= " Sign OK!<<<<< \n\n";
                file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
            }
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                //更新订单状态
                $oid = $_POST['out_trade_no'];     //商户订单号
                $info = [
                    'is_pay'        => 1,       //支付状态  0未支付 1已支付
                    'pay_amount'    => $_POST['total_amount'] * 100,    //支付金额
                    'pay_time'      => strtotime($_POST['gmt_payment']), //支付时间
                    'plat_oid'      => $_POST['trade_no'],      //支付宝订单号
                    'plat'          => 1,      //平台编号 1支付宝 2微信 
                ];
                OrderModel::where(['oid'=>$oid])->update($info);
            }
            //处理订单逻辑
            $this->dealOrder($_POST);
            echo 'success';
        }
        //验签
        function verify($params) {
            $sign = $params['sign'];
            $params['sign_type'] = null;
            $params['sign'] = null;
    
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
            
           
            
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
            ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
            //调用openssl内置方法验签，返回bool值
            $result = (openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256)===1);
            openssl_free_key($res);
            return $result;
        }
        /**
         * 处理订单逻辑 更新订单 支付状态 更新订单支付金额 支付时间
         * @param $data
         */
        public function dealOrder($data)
        {
            //加积分
            //减库存
        }
    }
    

