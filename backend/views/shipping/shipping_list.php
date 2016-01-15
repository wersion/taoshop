<?php 
use yii\helpers\Url;
?>
<table id="shippinglist"  class="easyui-datagrid" title="配送方式" 
				data-options="rownumbers:true,singleSelect:true,pagination:true,url:'<?= Url::to('/shipping/ajax-get')?>' ">
			<thead>
				<tr>
					<th data-options="field:'name',width:200,align:'center'">配送方式名称</th>
					<th data-options="field:'desc',width:350,align:'center'">配送方式描述</th>
					<th data-options="field:'insure_fee',width:80,align:'center'">保价费用</th>
					<th data-options="field:'cod',width:70,align:'center'" formatter="formatCod">货到付款？</th>
					<th data-options="field:'version',width:110,align:'center'">插件版本</th>
					<th data-options="field:'author',width:110,align:'center'">插件作者</th>
					<th data-options="field:'shipping_order',width:80,align:'center'">排序</th>
					<th data-options="field:'manage',width:200,align:'center'">操作</th>
				</tr>
			</thead>
		</table>
<script type="text/javascript">
function formatCod(val,row){
	if (val == true){
	    return "<img src='/images/ok.png' />";
	}else{
		return "<img src='/images/no.png' />";
	}
}
</script>