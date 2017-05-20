<?php
/**
 * file:blog.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 正文
 */
$this->cs->registerPackage('prettify');
$this->cs->registerScript('run_prettify', 'prettyPrint();');
$this->cs->registerScript('scrollOffset', "var offset = 75;");
$this->cs->registerScript('share-js', 'window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"2","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];');
$this->cs->registerScript('fraudmetrix', '
(function() {
    _fmOpt = {
        partner: "kf_Qox",
        appName: "kf_Qox_web",
        token: "' . Yii::app()->session->getSessionID() . '"
    };
    var cimg = new Image(1,1);
    cimg.onload = function() {
        _fmOpt.imgLoaded = true;
    };
    cimg.src = "https://fp.fraudmetrix.cn/fp/clear.png?partnerCode=" + _fmOpt.partner + "&appName=" + _fmOpt.appName + "&tokenId=" + _fmOpt.token;
    var fm = document.createElement("script"); fm.type = "text/javascript"; fm.async = true;
    fm.src = ("https:" == document.location.protocol ? "https://" : "http://") + "static.fraudmetrix.cn/fm.js?ver=0.1&t=" + (new Date().getTime()/3600000).toFixed(0);
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(fm, s);
})();
');
?>
<div class="row">
    <div class="col-md-12 blog-container-breadcrumbs">
        <?php
        $this->widget('Breadcrumbs', array(
            'links' => array(
                'Home' => $this->createUrl('index/index'),
                'Blog' => $this->createUrl('blog/index'),
                $post->category_name => $this->createUrl('blog/tag', array('id' => $post->category_id)),
                $post->title
            )
        ));
        ?>
    </div>
    <div class="col-md-9 blog-container-content">
        <div class="page-header"><span><a href="#comment" class="btn btn-default">留下足迹</a></span>

            <h2><?php echo $post->title; ?></h2></div>
        <div class="panel">
            <div class="panel-body">
                <!--<pre><?php echo CHtml::encode($post->abstract); ?></pre>-->
                <?php echo $post->content; ?>
                <?php $url = $this->createUrl('blog/post', array('id' => $post->id)); ?>
                <p>本文地址：<a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
            </div>
            <div class="panel-footer">
            <span class="bdsharebuttonbox">
                <a href="#" class="bds_more" data-cmd="more"></a>
                <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
            </span>
			<span>
				归档日期：
				<a href="<?php echo $this->createUrl('blog/date', array('id' => $post->date)); ?>"><?php echo date('Y年n月', $post->time); ?></a>
			</span>
                创建于：<?php echo date('Y-m-d', $post->time); ?> By <?php echo $post->username; ?>
            </div>
        </div>
        <ul class="pager">
            <li class="previous"><a href="<?php echo $this->createUrl('blog/post', array('id' => $prev)); ?>">&larr;
                    上一篇</a></li>
            <li class="next"><a href="<?php echo $this->createUrl('blog/post', array('id' => $next)); ?>">下一篇 &rarr;</a>
            </li>
        </ul>
        <div class="page-header"><h4>留下足迹</h4><a name="comment"></a></div>
        <ul class="list-group commentList" id="commentList">
            <?php $this->widget('red.zii.widget.RedListView', array(
                'dataProvider' => $comment,
                'itemView' => '/blog/comment/commentList',
                'viewTag' => $post->comment_state,
                'template' => '{items}',
                'emptyText' => '',
            )); ?>
        </ul>
        <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
        <?php if ($post->comment_state == 0) {
            $this->renderPartial('/blog/comment/commentBox', array(
                'post' => $post,
                'model' => $model
            ));
        } ?>
    </div>
    <?php $this->renderPartial('/blog/sidebar', array(
        'archive' => $archive,
        'category' => $category,
        'link' => $link,
    )); ?>
</div>