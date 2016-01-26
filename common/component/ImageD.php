<?php
namespace common\component;

class ImageD
{

    /**
     * 图片上传的处理函数
     *
     * @access public
     * @param
     *            array upload 包含上传的图片文件信息的数组
     * @param
     *            array dir 文件要上传在$this->data_dir下的目录名。如果为空图片放在则在$this->images_dir下以当月命名的目录下
     * @param
     *            array img_name 上传图片名称，为空则随机生成
     * @return mix 如果成功则返回文件名，否则返回false
     */
    public function UploadImage($upload, $dir = '', $img_name = '')
    {
        if (empty($dir)) {
            $dir = date('Ym');
            $dir =  \yii::getAlias('@static') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR;
        } else {
            $dir =  \yii::getAlias('@static') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR;
            if ($img_name) {
                $img_name = $dir . $img_name;
            }
        }
        
        if (! file_exists($dir)) {
            if (!$this->make_dir($dir)){
                return false;
            }
        }
        
        
        if (empty($img_name)){
            $img_name = $this->unique_name($dir);
            $img_name = $dir . $img_name . UtilD::get_filetype($upload['name']);
        }

        if (!UtilD::check_img_type($upload['type'])){
            return false;
        }
        //允许上传的类型
        $allow_file_types = ['gif','jpg','jpeg','png','bmp','swf'];//'|GIF|JPG|JEPG|PNG|BMP|SWF|';
        if (!UtilD::check_file_type($upload['tmp_name'],$img_name,$allow_file_types)){
            return false;
        }
        if ($this->move_file($upload,$img_name)){
            return str_replace(\yii::getAlias('@static') . DIRECTORY_SEPARATOR, '', $img_name);
        }
        else{
            return false;
        }
    }
    
    private function move_file($upload,$target){
        if (!$this->move_upload_file($upload['tmp_name'], $target)){
            return false;
        }
        return true;
    }
    
    private function move_upload_file($file_name,$target_name = '')
    {
        if (function_exists("move_uploaded_file")){
            if (move_uploaded_file($file_name, $target_name)){
                @chmod($target_name, 0755);
                return true;
            }
            elseif (copy($file_name, $target_name)){
                @chmod($target_name, 0755);
                return true;
            }
        }
        elseif (copy($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
        return false;
    }
    
    /**
     *  生成指定目录不重名的文件名
     *
     * @access  public
     * @param   string      $dir        要检查是否有同名文件的目录
     *
     * @return  string      文件名
     */
    public function unique_name($dir)
    {
        $filename = '';
        while (empty($filename))
        {
            $filename = UtilD::random_filename();
            if (file_exists($dir . $filename . '.jpg') || file_exists($dir . $filename . '.gif') || file_exists($dir . $filename . '.png'))
            {
                $filename = '';
            }
        }
    
        return $filename;
    }

    /**
     * 检查目标文件夹是否存在，如果不存在则自动创建该目录
     *
     * @access public
     * @param  string folder 目录路径。不能使用相对于网站根目录的URL      
     * @return bool
     */
    public function make_dir($folder)
    {
        $reval = false;
        
        if (! file_exists($folder)) {
            /* 如果目录不存在则尝试创建该目录 */
            @umask(0);
            
            /* 将目录路径拆分成数组 */
            preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
            
            /* 如果第一个字符为/则当作物理路径处理 */
            $base = ($atmp[0][0] == '/') ? '/' : '';
            
            /* 遍历包含路径信息的数组 */
            foreach ($atmp[1] as $val) {
                if ('' != $val) {
                    $base .= $val;
                    
                    if ('..' == $val || '.' == $val) {
                        /* 如果目录为.或者..则直接补/继续下一个循环 */
                        $base .= '/';
                        
                        continue;
                    }
                } else {
                    continue;
                }
                
                $base .= '/';
                
                if (! file_exists($base)) {
                    /* 尝试创建目录，如果创建失败则继续循环 */
                    if (@mkdir(rtrim($base, '/'), 0777)) {
                        @chmod($base, 0777);
                        $reval = true;
                    }
                }
            }
        } else {
            /* 路径已经存在。返回该路径是不是一个目录 */
            $reval = is_dir($folder);
        }
        
        clearstatcache();
        
        return $reval;
    }
}

?>