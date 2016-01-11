<?php
namespace common\component;
/**
 * help tools
 *
 * @author tao
 */
class UtilD {
    
    /**
     * 
     * @param bool $status   true|false
     * @param string $message   
     */
    public static function toJson($status,$message){
        return json_encode([
            'status' => $status?true:false,
            'message'=> $message
        ],JSON_FORCE_OBJECT);
    }
    
    public static function getCache($class,$key){
        $className = strtolower($class);
        if(!$class || !isset(\yii::$app->params['dataCache'][$class])){
            $className = 'default';
        }
        $id = \Yii::$app->params['dataCache'][$className]['cacheid'];
        if (\Yii::$app->$id){
            return \yii::$app->$id->get($key);
        }
        return false;
    }
    
    public static function setCache($class,$key,$data,$expire=86400){
         $className = strtolower($class);
        if(!$class || !isset(\yii::$app->params['dataCache'][$class])){
            $className = 'default';
        }
        $id = \Yii::$app->params['dataCache'][$className]['cacheid'];
        if (\Yii::$app->$id){
            return \yii::$app->$id->set($key,$data,$expire); 
        }
        return false;
    }
    
    /**
     * 有[&#]的数据转换成正常数据
     */
    public static function deSlashes($value, $ucfirst = false) {
        if (empty ( $value )) {
            return $value;
        }
        if(mb_check_encoding($value,'GBK') !== true){
            $value=self::filterPartialUTF8Char($value);
        }
        if(mb_check_encoding($value,'GBK') == false && mb_check_encoding($value,'UTF-8') == false){
            return '';
        }
        if (mb_check_encoding($value,'GBK') == true && mb_check_encoding($value,'UTF-8')!==true){
            $value = mb_convert_encoding($value, 'UTF-8', 'GBK');
        }
        if(strpos($value,'&')!==false){
            $value =htmlspecialchars_decode($value, ENT_QUOTES|ENT_NOQUOTES);
        }
        if(strpos($value,'&#')===false){
            return $value;
        }
    
        $filters = array ('&' => '&#' . ord ( '&' ) . ';', '#' => '&#' . ord ( '#' ) . ';', ' ' => '&#' . ord ( ' ' ) . ';', '\'' => '&#' . ord ( '\'' ) . ';', '>' => '&#' . ord ( '>' ) . ';',
            '<' => '&#' . ord ( '<' ) . ';', '=' => '&#' . ord ( '=' ) . ';', '!' => '&#' . ord ( '!' ) . ';', '^' => '&#' . ord ( '^' ) . ';', '+' => '&#' . ord ( '+' ) . ';',
            '-' => '&#' . ord ( '-' ) . ';', '*' => '&#' . ord ( '*' ) . ';', '/' => '&#' . ord ( '/' ) . ';', '%' => '&#' . ord ( '%' ) . ';', '|' => '&#' . ord ( '|' ) . ';',
            '~' => '&#' . ord ( '~' ) . ';', '@' => '&#' . ord ( '@' ) . ';','"' => '&#' . ord ( '"' ) . ';',';' => '&#' . ord ( ';' ) . ';' );
        $value = strtr ( $value, array_flip ( $filters ) );
        if ($ucfirst === true) {
            $value = strtolower ( $value );
        }
        return $value;
    
    }
    /**
     * 在页面操作完之后生成JavaScript的提示和页面跳转
     * @param string    $message        alert的提示文字
     * @param string    $url            可选参数，需要跳转的URL地址
     * @param string    $level          可选参数，top,parent用于iframe内部页面的跳转控制
     * @author dcl 2012-02-27
     * @example 调用 UtilD::toJavaScriptAlert("提交成功", "?r=admin/shop/index");
     * @example 输出 <script>parent.alert("提交成功");parent.location.href='?r=admin/shop/index';</script>
     * @example 输出后自动 Yii::app()->end();
     */
    public static function toJavaScriptAlert($message, $url = '', $level = 'parent' ){
        $iframe = ($level == '') ? '' : $level .".";
        $result  = "<script type='text/javascript'>" . $iframe . "alert('" . $message . "');";
        if ($url != '' && $url != 'back' && $url != 'close'){
            if(substr($url, 0,4) == 'http' || substr($url, 0,1) == '/'){
                //如果url为网址则直接跳转到网址，否则跳到来源页
            }else{
                $page_referer = self::deSlashes(Yii::app()->request->getPost("PAGE_REFERER", ""));
                if ($page_referer != ''){//如果视图页面有指定的跳转页面，优先使用跳转，没有则使用控制器指定的默认页面
                    $url = $page_referer;
                }
            }
    
            $result .= $iframe . "location.href='" . $url . "';";
        }
        elseif ($url =='back') {
            $result .="history.back();";
        }elseif ($url =='close') {
            $result .="window.close();";
        }
        $result  .= "</script>";
        echo $result;
    }
    
    /**
    * 检查文件类型
    *
    * @access      public
    * @param       string      filename            文件名
    * @param       string      realname            真实文件名
    * @param       array      limit_ext_types     允许的文件类型
    * @return      string
    */
   public static function check_file_type($filename, $realname = '', $limit_ext_types = [])
   {
       if ($realname)
       {
           $extname = strtolower(substr($realname, strrpos($realname, '.') + 1));
       }
       else
       {
           $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
       }

       if ($limit_ext_types && !in_array($extname, $limit_ext_types))
       {
           return '';
       }

       $str = $format = '';

       $file = @fopen($filename, 'rb');
       if ($file)
       {
           $str = @fread($file, 0x400); // 读取前 1024 个字节
           @fclose($file);
       }
       else
       {
           if (stristr($filename, ROOT_PATH) === false)
           {
               if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
                   $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
                   $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
                   $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert'|| $extname == 'pptx' || 
                   $extname == 'xlsx' || $extname == 'docx')
               {
                   $format = $extname;
               }
           }
           else
           {
               return '';
           }
       }

       if ($format == '' && strlen($str) >= 2 )
       {
           if (substr($str, 0, 4) == 'MThd' && $extname != 'txt')
           {
               $format = 'mid';
           }
           elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav')
           {
               $format = 'wav';
           }
           elseif (substr($str ,0, 3) == "\xFF\xD8\xFF")
           {
               $format = 'jpg';
           }
           elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt')
           {
               $format = 'gif';
           }
           elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
           {
               $format = 'png';
           }
           elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt')
           {
               $format = 'bmp';
           }
           elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS') && $extname != 'txt')
           {
               $format = 'swf';
           }
           elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0")
           {   // D0CF11E == DOCFILE == Microsoft Office Document
               if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'doc')
               {
                   $format = 'doc';
               }
               elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls')
               {
                   $format = 'xls';
               } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'ppt')
               {
                   $format = 'ppt';
               }
           } elseif (substr($str ,0, 4) == "PK\x03\x04")
           {
               if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'docx')
               {
                   $format = 'docx';
               }
               elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xlsx')
               {
                   $format = 'xlsx';
               } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'pptx')
               {
                   $format = 'pptx';
               }else
               {
                   $format = 'zip';
               }
           } elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt')
           {
               $format = 'rar';
           } elseif (substr($str ,0, 4) == "\x25PDF")
           {
               $format = 'pdf';
           } elseif (substr($str ,0, 3) == "\x30\x82\x0A")
           {
               $format = 'cert';
           } elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt')
           {
               $format = 'chm';
           } elseif (substr($str ,0, 4) == "\x2ERMF")
           {
               $format = 'rm';
           } elseif ($extname == 'sql')
           {
               $format = 'sql';
           } elseif ($extname == 'txt')
           {
               $format = 'txt';
           }
       }

       if ($limit_ext_types && !in_array($format, $limit_ext_types))
       {
           $format = '';
       }

       return $format;
   }
}
