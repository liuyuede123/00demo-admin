
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="website/">配置列表</a> >> 添加配置
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">配置名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" data-bv-notempty>
						</div>
					</div>
					<div class="form-group">
						<label for="attr" class="col-sm-2 control-label">属性名</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">config_</span>
								<input class="form-control" name="attr" id="attr">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="value" class="col-sm-2 control-label">属性值</label>
						<div class="col-sm-10">
							<input class="form-control" name="value" id="value">
						</div>
					</div>
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
			name: {
				validators: {
					notEmpty: {
						message: '配置名不能为空'
					}
				}
			},
			attr: {
				validators: {
					notEmpty: {
						message: '属性名不能为空'
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
		$.post(admin.url+'website/add_config_action',
			$('form').serialize(),
			function (data){
				data = $.parseJSON(data);
				if(data.status){
					layer.msg('添加成功', {icon: 1, time: 2000}, function(){
						location.href = admin.url+'website/';
					});
				}else{
					layer.msg(data.msg, {icon: 5, time: 2000});
				}
			})
	}
}

</script>