
		<div class="panel panel-default">
			<div class="panel-heading">
				配置列表 <a class="btn btn-info" href="website/add_config">添加配置</a>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8" role="form">
					<?php foreach($config_list as $v): ?>
					<div class="form-group">
						<label for="<?php echo $v['attr']; ?>" class="col-sm-2 control-label"><?php echo $v['name']; ?></label>
						<div class="col-sm-8">
							<input class="form-control" name="value[]" id="<?php echo $v['attr']; ?>" value="<?php echo $v['value']; ?>">
							<input type="hidden" name="id[]" value="<?php echo $v['id']; ?>">

						</div>
						<div class="col-sm-1"><button type="button" class="btn btn-danger" onclick="del_config(<?php echo $v['id']; ?>)">删除</button></div>
						<div class="col-sm-1"><?php echo $v['attr']; ?></div>
					</div>
					<?php endforeach ?>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="save_config()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->

<!-- /.row -->

<script>
$(function () {
	$('form').bootstrapValidator({
	　　　message: 'This value is not valid',
		　feedbackIcons: {
			　　　　　　　　valid: 'glyphicon glyphicon-ok',
			　　　　　　　　invalid: 'glyphicon glyphicon-remove',
			　　　　　　　　validating: 'glyphicon glyphicon-refresh'
		　　　　　　　　   },
		fields: {
			'value[]': {
				validators: {
					notEmpty: {
						message: '配置值不能为空'
					}
				}
			}
		}
	});
});
function save_config(){
	//验证表单
	var bootstrapValidator = $('form').data('bootstrapValidator');
	bootstrapValidator.validate();
	if(bootstrapValidator.isValid()){
		$.post(admin.url+'website/save_config',
		$('form').serialize(),
		function (){
			layer.msg('保存成功', {icon: 1, time: 2000}, function(){
				location.reload();	
			});
		})
	}
}

function del_config(id){
	//询问框
	layer.confirm('确认删除该配置？', {
	  btn: ['确认','取消'] //按钮
	}, function(){
		$.post(admin.url+'website/del_config',
		{id:id},
		function (){
			layer.msg('删除成功', {icon: 1, time: 2000}, function(){
				location.reload();	
			});
		})
	});
}

</script>