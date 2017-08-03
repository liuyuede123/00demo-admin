
		<div class="panel panel-default">
			<div class="panel-heading">
				文章分类列表 <a class="btn btn-primary" href="category/edit_cate">添加分类</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>分类名</th>
								<th>分类URL</th>
								<th>包含文章</th>
								<th>相册</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($cate_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><a href="<?php echo $site_url.$v['url']; ?>" target="_blank"><?php echo $site_url.$v['url']; ?></a></td>
								<td>
									<div class="btn-group">
										<a href="category/article_list/<?php echo $v['id']; ?>" class="btn btn-info">查看文章</a>
									</div>
								</td>
								<td>
									<div class="btn-group">
										<a class="btn btn-success" href="category/edit_album/<?php echo $v['id']; ?>">查看相册</a>
									</div>
								</td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="category/edit_cate/<?php echo $v['id']; ?>">编辑</a>
										<button type="button" class="btn btn-danger" onclick="del_cate(<?php echo $v['id']; ?>)">删除</button>
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

<!-- /.row -->

<script>
	
function del_cate(id){
	//询问框
	layer.confirm('确认删除该分类？该操作不可恢复，请谨慎操作！若该分类下有文章或相册，请先清空该分类下的文章和相册', {
	  btn: ['确认','取消'] //按钮
	}, function(){
	  $.post(admin.url+'category/del_cate',
		{'id': id},
		function (result){
			result = $.parseJSON(result);
			if(result.status){
				layer.msg('删除成功！', {icon: 1}, function(){
					location.reload();
				});
			}else{
				layer.msg(result.msg, {icon: 5});
			}
		})
	});
}

</script>