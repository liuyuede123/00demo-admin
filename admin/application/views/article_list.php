
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $cate_info['title']; ?>--文章列表 >>  <a class="btn btn-primary" href="category/edit_article/<?php echo $cate_id; ?>">添加文章</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>文章标题</th>
								<th>点击量</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($article_list as $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><?php echo $v['title']; ?></td>
								<td><?php echo $v['click']; ?></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo $site_url.$cate_info['url'].'/'.$v['id']; ?>" target="_blank" class="btn btn-info">浏览</a>
										<a class="btn btn-primary" href="category/edit_article/<?php echo $cate_id.'/'.$v['id']; ?>">编辑</a>
										<a class="btn btn-success" href="category/edit_art_album/<?php echo $v['id']; ?>">相册</a>
										<button type="button" class="btn btn-danger" onclick="del_article(<?php echo $v['id']; ?>)">删除</button>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
					<?php echo $pagin; ?>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->


<script>
	
function del_article(id){
	//询问框
	layer.confirm('确认删除该文章？该操作不可恢复，请谨慎操作！', {
	  btn: ['确认','取消'] //按钮
	}, function(){
		$.post(admin.url+'category/del_article',
		{'id': id},
		function (){
			layer.msg('删除成功', {icon: 1, time: 2000}, function(){
				location.reload();	
			});
		})
	});
}

</script>