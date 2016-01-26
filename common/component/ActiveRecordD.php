<?php
namespace common\component;

use yii\db\ActiveRecord;
use yii\db\Query;
class ActiveRecordD extends ActiveRecord
{
    public $pageCacheTime = 1600; //秒
    /**
     * 按条件分页返回
     * @param integer $page
     * @param integer $pageSize
     * @param Query $q
     * @param boolean $isCache
     * @param boolean $forceCacheTime
     * @param boolean $withCount
     */
    public function getListByPage($page,$pageSize,$q = NULL,$isCache=true,$forceCacheTime=false,$withCount=true){
        if ($isCache){
            $className = strtolower(get_called_class());
            $listKey = $this->genListMemkey($page,$pageSize,$q,$forceCacheTime);
            $return = UtilD::getCache($className, $listKey);
            if ($return)
                return $return;
        }
        if ($page < 1 || $pageSize <1){
            $query = $q->all();
            if (empty($query)){
                $return['total'] = 0;
                $return['rows']  = [];
            }
            else{
                $return['total'] = $q->count();
                foreach ($query as $rs){
                    $return['rows'][] = $rs;
                }
            }
        }
        else{
            if ($pageSize > 1 && $withCount){
                $q2 = clone $q;
                $count = $q2->count();
            }else{
                $count = 1;
            }
            if ($count < 1){
                $return = ['total'=>0,'rows'=>[]];
            }
            else{
                if ($page < 1){
                    $page = 0;
                }else{
                    $page = $page - 1;
                }
                $offset = $page * $pageSize;
                if ($offset >= $count){
                    $return = ['total'=>$count,'rows'=>[]];
                }
                else{
                    $q->offset = $offset;
                    $q->limit = $pageSize;
                    $query = $q->all();
                    if (empty($query) || !$withCount){
                        $count = 0;
                    }
                    $return['total'] = $count;
                    $return['rows'] = [];
                    foreach ($query as $val){
                        $return['rows'][] = $val;
                    }
                }
            }
        }
        if ($isCache){
            $cacheTime = $forceCacheTime === false ? $this->pageCacheTime : $forceCacheTime;
            UtilD::setCache($className, $listKey, $return,$cacheTime);
        }
        return $return;
    }
    
    /*
     * 产生在CACHED中缓存的列表页结果集对应的key
     */
    private function genListMemkey($page,$pageSize,$query,$forceCacheTime = false) {
         $key = 'cache_list';
         $className = strtolower(get_called_class());
         $key .='_'.$className;
         if ($forceCacheTime === false){
             $version = $this->getMemVersion();
             $lastVersion = $version --;
             $key .=  '_version' . $version;
         }
         $key .= '_'.md5(serialize($query));
         $key .= '_'.$pageSize.'_'.$page;
         if ($forceCacheTime === false){
             $lastKey = str_replace('_version'.$version, '_version'.$lastVersion, $key);
             $this->removePageMem($lastKey);
         }
         return $key;
    }
    
    private function removePageMem($key){
        $class = strtolower(get_called_class());
        return UtilD::setCache($class, $key, '',-1);
    }
    
    private function getMemVersion(){
        $className = strtolower(get_called_class());
        $key = 'keyVersion_'.$className;
        $version = UtilD::getCache($className, $key);
        if (!$version){
            $version = 1;
            UtilD::setCache($className, $key, $version,3600);
        }
        return $version;
    }
}

?>