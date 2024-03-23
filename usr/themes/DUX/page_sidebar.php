<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    <!-- start sidebar -->
    <aside class="sidebar">
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
    <div class="widget widget-tops">
        <ul class="widget-nav"><li class="active">最新文章</li></ul>
        <ul class="widget-navcontent">
            <li class="item item-01 active">
                <ul>
<?php $this->widget('Widget_Contents_Post_Recent','pageSize=5')->to($post); ?>
<?php while($post->next()): ?>
                    <li><time><?php $post->date('m-d'); ?></time><a href="<?php $post->permalink(); ?>" title="<?php $post->title(); ?>"><?php $post->title(); ?></a></li>
<?php endwhile; ?>
                </ul>
            </li>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
    <div class="widget widget-tops" style="background:url(https://shuxun.wang/1.jpg")>
        <ul class="widget-nav"><li class="active">站点统计</li></ul>
        <ul class="widget-navcontent">
            <li class="item item-01 active">
                <ul>
<?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
<li>文章总数：<?php $stat->publishedPostsNum() ?>篇</li>
<li>分类总数：<?php $stat->categoriesNum() ?>个</li>
<li>评论总数：<?php $stat->publishedCommentsNum() ?>条</li>
<li><?php PageViews_Plugin::showPageViews(); ?></li>
<li>本站运营：<?php getBuildTime(); ?></li>
                </ul>
            </li>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
    <?php
        $sad1=sitebar_ad($this->options->sidebarAD);
        $maxi=floor(count($sad1)/3);
        for($i=1;$i<=$maxi;$i++){
            $icss=($i%2)+1;
            $tmp='<div class="widget widget_ui_textasb"><a class="style0'.$icss.'" href="'.$sad1[$i*3-3].'" target="_blank"><strong>最新推荐</strong><h2>'.$sad1[$i*3-2].'</h2><p>'.$sad1[$i*3-1].'</p></a></div>';
            echo $tmp;
        }
    ?>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
    <div class="ds-recent-comments" data-num-items="5" data-show-avatars="1" data-show-time="1" data-show-title="1" data-show-admin="1" data-excerpt-length="70"></div>
    <div class="widget widget_ui_comments">
        <h3>最新评论</h3>
        <ul>
<?php $this->widget('Widget_Comments_Recent','pageSize=7')->to($comments); ?>
<?php while($comments->next()): ?>
            <li>
            <a href="<?php $comments->permalink(); ?>" title="<?php $comments->title(); ?>上的评论">
                <strong><?php $comments->author(false); ?></strong> (<?php $comments->date('m-d'); ?>) 说：
                <br><?php $comments->excerpt(22, '...'); ?></a></li>
<?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>
    </aside>
    <!-- end sidebar -->
