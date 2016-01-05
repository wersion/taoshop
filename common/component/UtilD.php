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
}
