<?php
namespace common\extensions\payment;
/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wx_new_qrcode_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'TAOSHOP TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.mythlink.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'appid',           'type' => 'text',   'value' => ''),
        array('name' => 'mchid',               'type' => 'text',   'value' => ''),
        array('name' => 'key',           'type' => 'text',   'value' => ''),
        array('name' => 'appsecret',           'type' => 'text',   'value' => ''),
		array('name' => 'logs',           'type' => 'text',   'value' => ''),
    );

    return;
}

class wx_new_qrcode
{
	function __construct()
	{
		$payment = get_payment('wx_new_qrcode');
    
        if(!defined('WXAPPID'))
        {
            $root_url = str_replace('mobile/', '', $GLOBALS['ecs']->url());
            define("WXAPPID", $payment['appid']);
            define("WXMCHID", $payment['mchid']);
            define("WXKEY", $payment['key']);
            define("WXAPPSECRET", $payment['appsecret']);
            define("WXCURL_TIMEOUT", 30);
            define('WXNOTIFY_URL',$root_url.'wx_native_callback.php');
            define('WXSSLCERT_PATH',dirname(__FILE__).'/WxPayPubHelper/cacert/apiclient_cert.pem');
            define('WXSSLKEY_PATH',dirname(__FILE__).'/WxPayPubHelper/cacert/apiclient_key.pem');
            
            define('WXJS_API_CALL_URL',$root_url.'wx_refresh.php');
        }
        require_once(dirname(__FILE__)."/WxPayPubHelper/WxPayPubHelper.php");

	}
	function get_code($order, $payment)
	{
        $unifiedOrder = new UnifiedOrder_pub();

        $unifiedOrder->setParameter("body",$order['order_sn']);//商品描述
        $out_trade_no = $order['order_sn'];
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
        $unifiedOrder->setParameter("attach",strval($order['log_id']));//商户支付日志
        $unifiedOrder->setParameter("total_fee",strval(intval($order['order_amount']*100)));//总金额
        $unifiedOrder->setParameter("notify_url",WXNOTIFY_URL);//通知地址 
        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型

        $unifiedOrderResult = $unifiedOrder->getResult();
        
        $html = '<button type="button" onclick="javascript:alert(\'出错了\')">微信支付</button>';

        if($unifiedOrderResult["code_url"] != NULL)
        {
            $code_url = $unifiedOrderResult["code_url"];
            $html = '<div class="wx_title">';
            $html .= '<span id="wxlogo"><img src="/themes/main/images/weixin/WePayLogo.jpg" width="148" height="40"/></span>';
            $html .= '<span id="tj"><img src="/themes/main/images/weixin/We_tj.jpg" width="47" height="20"/></span>';
            $html .= '<span id="desc">亿万用户的选择，更快更安全</span>';
            $html .= '<span id="price">支付：<font style="color:#ff6600">'.$order['order_amount'].'</font> 元</span>';
            $html .= '</div>';
            $html .= '<div class="wx_qrcode" style="text-align:center">';
            $html .= $this->getcode($code_url);
            $html .= "</div>";

            $html .= "<div style=\"text-align:center\"><img src=\"/themes/main/images/weixin/wxfont.png\" width=\"186\" height=\"62\"></div>";
        }
        
        

        return $html;
	}
    function respond()
    {
        $payment  = get_payment('wx_new_qrcode');

        $notify = new Notify_pub();
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        
        if($payment['logs'])
        {
            $this->log(ROOT_PATH.'/data/wx_new_log.txt',"传递过来的XML\r\n".var_export($xml,true));
        }
        $notify->saveData($xml);
        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                if($payment['logs']){
                    $this->log(ROOT_PATH.'/data/wx_new_log.txt',"return_code失败\r\n");
                }
            }elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                if($payment['logs']){
                    $this->log(ROOT_PATH.'/data/wx_new_log.txt',"result_code失败\r\n");
                }
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                if($payment['logs']){
                    $this->log(ROOT_PATH.'/data/wx_new_log.txt',"支付成功\r\n");
                }
                $total_fee = $notify->data["total_fee"];
                $log_id = $notify->data["attach"];
                $sql = 'SELECT order_amount FROM ' . $GLOBALS['ecs']->table('pay_log') ." WHERE log_id = '$log_id'";
                $amount = $GLOBALS['db']->getOne($sql);
                
                if($payment['logs'])
                {
                    $this->log(ROOT_PATH.'/data/wx_new_log.txt','订单金额'.$amount."\r\n");
                }
                /* 检查支付的金额是否相符 */
                if(intval($amount*100) != $total_fee)
                {
                    
                    if($payment['logs'])
                    {   
                        $this->log(ROOT_PATH.'/data/wx_new_log.txt','订单金额不符'."\r\n");
                    }
                    
                    echo 'fail';
                    return false;
                }

                order_paid($log_id, 2);
                return true;
            }

        }
        else
        {
            $this->log(ROOT_PATH.'/data/wx_new_log.txt',"签名失败\r\n");
        }
        return false;
    }


    function getcode($url){
        if(file_exists(ROOT_PATH . 'includes/phpqrcode.php')){
            include(ROOT_PATH . 'includes/phpqrcode.php');
        }
        // 纠错级别：L、M、Q、H 
        $errorCorrectionLevel = 'Q';  
        // 点的大小：1到10 
        $matrixPointSize = 5;
        // 生成的文件名
        $tmp = ROOT_PATH .'images/qrcode/';
        if(!is_dir($tmp)){
            @mkdir($tmp);
        }
        $newFilename = hash('md5', uniqid(mt_rand(), true));
        $filename = $tmp . $newFilename.$errorCorrectionLevel . $matrixPointSize . '.png';
        QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        return '<img src="'.$GLOBALS['ecs']->url(). 'images/qrcode/'.basename($filename).'?v='.time().'" />';
    }
    
    function log($file,$txt)
    {
       $fp =  fopen($file,'ab+');
       fwrite($fp,'-----------'.local_date('Y-m-d H:i:s').'-----------------');
       fwrite($fp,$txt);
       fwrite($fp,"\r\n\r\n\r\n");
       fclose($fp);
    }
    
}
