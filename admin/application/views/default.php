
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>">

    <title>广东壹银贵金属经营有限公司</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?php echo $site_url; ?>plugins/ueditor/themes/default/css/ueditor.css" type="text/css"> -->
    <link href="css/common.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
    <script src="js/common.js"></script>
    <script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- Page-Level Plugin Scripts - Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!--弹窗插件-->
<script src="<?php echo $site_url; ?>plugins/layer/layer.js"></script>

<!--form验证-->
<link href="css/bootstrapValidator.min.css" rel="stylesheet">
<script src="js/bootstrapValidator.min.js"></script>

</head>



<body>

<div id="wrapper">
    <?php include 'common/top.php'; ?>
    <?php include 'common/sidebar.php'; ?>
    <div id="page-wrapper">
        <?php include $con_page.'.php'; ?>
    </div>
</div>


</body>
</html>


