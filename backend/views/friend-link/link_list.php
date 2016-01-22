<?php 
use yii\helpers\Url;
?>
<table id="friend-link-list"  class="easyui-datagrid" title="友情连接列表" 
				data-options="toolbar: '#btn-friend',rownumbers:true,fitColumns:true,singleSelect:true,pagination:true,url:'<?= Url::to('/friend-link/ajax-get')?>' ">
			<thead>
				<tr>
					<th data-options="field:'link_name',width:250,align:'center'">链接名称</th>
					<th data-options="field:'link_url',width:350,align:'center'">链接地址</th>
					<th data-options="field:'link_logo',width:300,align:'center'">链接LOGO</th>
					<th data-options="field:'show_order',width:150,align:'center',sortable:true">显示顺序</th>
					<th data-options="field:'manage',width:200,align:'center'">操作</th>
				</tr>
			</thead>
</table>
<div id="btn-friend" style="padding:4px">  
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add2" onclick="javascript:location.href='<?=Url::toRoute(['/shipping-area/add','shipping'=>0])?>'">添加链接</a>  
</div>