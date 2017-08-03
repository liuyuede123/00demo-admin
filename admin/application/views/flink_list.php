
		<div class="panel panel-default">
			<div class="panel-heading">
				友情链接列表 <a class="btn btn-primary" href="flink/edit_flink">添加友情链接</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>标题</th>
								<th>图片预览</th>
								<th>URL</th>
								<th>排序</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($flink_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><a href="../<?php echo $v['img']; ?>"  target="_blank"><img src="../<?php echo $v['img']; ?>" height="100" width="auto"></a> 
								</td>
								<td><a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['url']; ?></a></td>
								<td><?php echo $v['sort']; ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="flink/edit_flink/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_flink(<?php echo $v['id']; ?>)">删除</button>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->


<script>
	
function del_flink(id){
	layer.confirm('确认删除该友情链接？该操作不可恢复，请谨慎操作！', {
	  btn: ['确认','取消'] //按钮
	}, function(){
		$.post(admin.url+'flink/del_flink',
		{id:id},
		function (){
			layer.msg("删除成功", {icon: 1}, function(){
				location.reload();
			});
		})
	})
}

</script>