<?php
/**
 * file:main.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:主视图
 */
$this->cs->registerScript('nav', "
var current = window.location.href;
$('.nav li').each(function(){
    var href = $(this).find('a').attr('href');
    if(href == current){
        $('.nav li.active').removeClass('active');
        $(this).addClass('active');
    }else if(current.match('^'+href+'.*')){
        $('.nav li.active').removeClass('active');
        $(this).addClass('active');
    }
});
");
$this->cs->registerScript('baidu', '
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?e259f8f91c0fa95b00c128e2cb9c9503";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="baidu-site-verification" content="gMSvLHvnWi"/>
    <meta name="keywords" content="<?php echo CHtml::encode(join(',', $this->keyword)); ?>"/>
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <title><?php echo CHtml::encode($this->name . $this->app->name); ?></title>
    <link rel="shortcut icon" href="http://blog.toruneko.net/toruneko.ico" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script type="text/javascript"
            src="http://blog.toruneko.net<?php echo $this->assets; ?>js/html5shiv.min.js"></script>
    <script type="text/javascript"
            src="http://blog.toruneko.net<?php echo $this->assets; ?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Yii::app()->getHomeUrl(); ?>">Toruneko</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $this->createUrl('index'); ?>">Home</a></li>
                <li><a href="<?php echo $this->createUrl('blog'); ?>">Blog</a></li>
                <li><a href="http://wakfu.toruneko.net" target="_blank">WaKfu</a></li>
                <li><a href="https://github.com/toruneko/redlib" target="_blank">RedLib</a></li>
                <li><a href="<?php echo $this->createUrl('blog/rss'); ?>">RSS</a></li>
            </ul>
            <form action="<?php echo $this->createUrl('blog/search'); ?>" class="navbar-form navbar-right"
                  role="search">
                <div class="form-group">
                    <input type="text" name="kw" class="form-control" placeholder="关键字"/>
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid blog-container"><?php echo $content; ?></div>
<div class="container-fluid text-center">
    &copy; 2014 - <?php echo date('Y') ?> Toruneko. All rights reserved.
    <a href="http://www.miitbeian.gov.cn">浙ICP备15026355号</a><br/>
    <?php echo Yii::powered(); ?>
</div>
</body>
</html>
