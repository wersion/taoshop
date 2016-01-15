<?php 
use yii\helpers\Url;
?>
<table id="shippingarealist"  class="easyui-datagrid" title="配送区域" 
				data-options="toolbar: '#shippingarea-buttons',rownumbers:true,singleSelect:true,pagination:true,url:'<?= Url::toRoute(['/shipping-area/ajax-get','shipping'=>$shipping_id])?>' ">
			<thead>
				<tr>
					<th data-options="field:'name',align:'center'" width="10%">编号</th>
					<th data-options="field:'desc',align:'center'" width="30%">配送区域名称</th>
					<th data-options="field:'insure_fee',align:'center'" width="45%">所辖地区</th>
					<th data-options="field:'manage',align:'center'" width="12%">操作</th>
				</tr>
			</thead>
</table>
<div id="shippingarea-buttons" style="margin: 4px">  
	<a href="#" class="easyui-linkbutton" iconCls="icon-add2" onclick="javascript:location.href='<?=Url::toRoute(['/shipping-area/add','shipping'=>$shipping_id])?>'">新建配送区域</a>  
</div>