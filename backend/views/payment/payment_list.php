<?php 
use yii\helpers\Url;
?>
<table id="listdata"  class="easyui-datagrid" title="支付列表" 
				data-options="rownumbers:true,singleSelect:true,pagination:true,url:'<?= Url::to('/payment/ajax-get')?>' ">
			<thead>
				<tr>
					<th data-options="field:'name',width:200,align:'center'">支付方式名称</th>
					<th data-options="field:'desc',width:400,align:'center'">支付方式描述</th>
					<th data-options="field:'version',width:110,align:'center'">插件版本</th>
					<th data-options="field:'author',width:110,align:'center'">插件作者</th>
					<th data-options="field:'pay_fee',width:110,align:'center'">费用</th>
					<th data-options="field:'pay_order',width:110,align:'center'">排序</th>
					<th data-options="field:'manage',width:150,align:'center'">操作</th>
				</tr>
			</thead>
		</table>