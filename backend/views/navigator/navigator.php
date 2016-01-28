<?php 
use yii\helpers\Url;
?>
<table id="navigator-list"  class="easyui-datagrid" title="友情连接列表" 
				data-options="toolbar: '#btn-navigator',rownumbers:true,fitColumns:true,singleSelect:true,pagination:true,url:'<?= Url::to('/navigator/ajax-get')?>' ">
			<thead>
				<tr>
					<th data-options="field:'link_name',width:250,align:'center'">名称</th>
					<th data-options="field:'link_url',width:350,align:'center'">是否显示</th>
					<th data-options="field:'link_logo',width:300,align:'center'">是否新窗口</th>
					<th data-options="field:'show_order',width:150,align:'center',sortable:true">排序</th>
					<th data-options="field:'location',width:150,align:'center'">位置</th>
				</tr>
			</thead>
</table>
<div id="btn-navigator" style="padding:4px">  
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add2" onclick="javascript:location.href='<?=Url::to('/navigator/add')?>'">添加导航</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" onclick="updateLink();">修改</a> 
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" onclick="deleteLink();">删除</a>   
</div>