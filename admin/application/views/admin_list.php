
		<div class="panel panel-default">
			<div class="panel-heading">
				管理员列表 <a href="admin/edit_admin/" class="btn btn-primary">添加管理员</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>账号</th>
								<th>昵称</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($admin_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['name']; ?></td>
								<td><?php echo $v['nick']; ?></td>
								<td>
									<div class="btn-group">
										<a href="admin/edit_admin/<?php echo $v['id']; ?>" class="btn btn-primary">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_admin(<?php echo $v['id']; ?>)">删除</button>
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


<script>
	
function del_admin(id){
	layer.confirm('确认删除该管理员？该操作不可恢复，请谨慎操作！', {
	  btn: ['确认','取消'] //按钮
	}, function(){
		$.post(admin.url+'admin/del_admin',
		{id:id},
		function (){
			layer.msg("删除成功", {icon: 1}, function(){
				location.reload();
			});
		})
	})
}

</script>