<?php

namespace common\component;
use Yii;
use yii\web\User;
use common\component\UtilD;
use backend\models\Admin;
/**
 * Description of WebUserD
 *
 * @author tao
 */
class WebUserD extends User{
   public $userType = 'front';
   const USER_KEY = 'Admin_userid_';


   public function getUsername(){
       $userInfo = $this->getUserInfo();
       return $userInfo ? $userInfo['username']:'';
   }
   
   /**
    * get user row data 
    * @return array userInfo
    */
   private function getUserInfo(){
       $user_id = $this->getId();
       $key = md5(self::USER_KEY.$user_id);
       $data = UtilD::getCache(__CLASS__, $key);
       if(!$data){
           $data = Yii::$app->getDb()
                   ->createCommand("SELECT * FROM {{%admin}} WHERE id=".$user_id." AND status=".Admin::STATUS_ACTIVE)
                   ->queryOne();
           if ($data){
                UtilD::setCache(__CLASS__, $key, $data);
           }
       }
       return $data;
   }
}
