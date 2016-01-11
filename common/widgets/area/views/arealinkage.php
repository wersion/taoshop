<?php
use yii\helpers\Url;
?>
<div class="<?=$prefix?>selectList">
    <select class="province" name="<?=$prefix?>province">
            <option>请选择</option>
        </select>
    <select class="city" name="<?=$prefix?>city" style="display: none">
            <option>请选择</option>
        </select>
    <select class="district" name="<?=$prefix?>district" style="display: none">
            <option>请选择</option>
        </select>
    <input type="hidden" name="<?=$name?>" id="<?=$prefix?>areaCode" />
</div>

<script type="text/javascript">

$(function(){
    $(".<?=$prefix?>selectList").each(function(){
        var <?=$prefix?>directCityCodes = ['101101','101102','101103','101104','101132','101133','101134'];//直辖市
        var initCode = '<?=$selectAreaCode?>';
        var areaData;
        var temp_html;
        var oProvince = $(this).find(".province");
        var oCity = $(this).find(".city");
        var oDistrict = $(this).find(".district");
        var oAreacode = $('#<?=$prefix?>areaCode');
        
        //init
        var province = function(){
            temp_html = "<option value='0'>请选择</option>";
            $.each(areaData,function(i,province){
               if(province != 'undefined'){
                    var sub6code = province.area_code.substr(0,6);
                    if (initCode.substr(0,6) == sub6code){
                        temp_html += "<option value='"+province.area_code+"' selected='selected'>"+province.area_name+"</option>";
                    }else{
                         temp_html += "<option value='"+province.area_code+"'>"+province.area_name+"</option>";
                    }
               }
            });
            oProvince.html(temp_html);
            if (initCode.length > 6){
                city();
            }
        };
        
        var city = function(){
            temp_html = "<option value='0'>请选择</option>";
            var parentCode = oProvince.val();
            
            /*if ($.inArray(parentCode.substr(0,6),<?=$prefix?>directCityCodes) > -1){
                oDistrict.css("display","none");
            }*/
            $.getJSON('<?= Url::toRoute($url)?>?area_code='+parentCode+'&dep=3',function(data){
                if (data == "undefined"){
                    oCity.css("display","none");
                }else{
                    oCity.css("display",'inline');
                    $.each(data,function(i,city){
                        var sub9code = city.area_code.substr(0,9);
                        if (initCode.substr(0,9) == sub9code){
                            temp_html += "<option value='"+city.area_code+"' selected='selected'>"+city.area_name+"</option>";
                        }else{
                            temp_html += "<option value='"+city.area_code+"'>"+city.area_name+"</option>";
                        }
                    });
                    oCity.html(temp_html);
                    if (initCode.length > 9){
                        district();
                    }
                }
            });
            
        };
        
        var district = function(){
            temp_html = "<option value='0'>请选择</option>";
            var parentCode = oCity.val();
            $.getJSON('<?= Url::toRoute($url)?>?area_code='+parentCode+'&dep=4',function(data){
                if (data == 'undefined'){
                    oDistrict.css("display","none");
                }else if ($.inArray(parentCode.substr(0,6),<?=$prefix?>directCityCodes) > -1){
                    oDistrict.css("display","none");
                }
                else{
                    oDistrict.css("display","inline");
                    $.each(data,function(i,district){
                         if (initCode == district.area_code){
                            temp_html += "<option value='"+district.area_code+"' selected='selected'>"+district.area_name+"</option>"; 
                         }
                         else{
                            temp_html += "<option value='"+district.area_code+"'>"+district.area_name+"</option>"; 
                         }
                    });
                    oDistrict.html(temp_html);
                }
            });
           
        };
        
        oProvince.change(function(){
            oAreacode.val(oProvince.val());
            city();
        });
        
        oCity.change(function(){
            oAreacode.val(oCity.val());
            district();
        });
        
        oDistrict.change(function(){
            oAreacode.val(oDistrict.val());
        });
        
        $.getJSON('<?= Url::toRoute([$url, 'area_code'=>101,'dep'=>2])?>',function(data){
           areaData = data;
           province();
        });
    });
});
</script>