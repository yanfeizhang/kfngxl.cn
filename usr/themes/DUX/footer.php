<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

    <!--footer-->
<?php if($this->options->footad && !empty($this->options->footad) ): ?>
    <div class="branding branding-black">
        <div class="container">
            <?php $this->options->footad(); ?>
        </div>
    </div>
<?php endif; ?>
    <footer id="footer" class="footer">
        <div class="container">
<?php if($this->options->flinks && !empty($this->options->flinks) ): ?>
            <div class="flinks">
                <strong>友情链接</strong>
                <ul class='xoxo blogroll'>
                    <?php $this->options->flinks(); ?>
                </ul>
            </div>
<?php endif; ?>
<?php if($this->options->fcode && !empty($this->options->fcode) ): ?>
            <div class="fcode"><?php $this->options->fcode(); ?></div>
<?php endif; ?>
            <div class="copyright">
                <p>
                    &copy; 2010 - <?php echo date("Y"); ?> <a href="<?php $this->options ->siteUrl(); ?>"><?php $this->options->title();?></a>
                    <?php if($this->options->miitbeian): ?> | <a href="http://beian.miit.gov.cn/" target="_blank" rel="nofollow"><?php $this->options->miitbeian(); ?></a><?php endif; ?>
                    <br>
                    <!--Powered by <a href="http://www.typecho.org/" target="_blank">Typecho</a> |
                    Theme <a href="https://github.com/hiCasper/Typecho-theme-DUX" target="_blank">DUX</a>-->
                    本站部分图片、文章来源于网络，版权归原作者所有，如有侵权，请联系我们删除。
                </p>
            </div>
            <div class="hide"></div>
        </div>
    </footer>
<?php if ($this->options->useHighline == 'able'): ?>
    <script src="<?php $this->options->themeUrl('css/highlight.min.js '); ?>"></script>
<?php endif; ?>
    <script>
        window.jsui={
            www: '<?php $this->options ->siteUrl(); ?>',
            uri: '<?php echo rtrim($this->options ->themeUrl,"/");?>',
            ver: '1.0',
            roll: [<?php if (!empty($this->options->sitebar_fu)) {$text = $this->options->sitebar_fu;} else{$text='1';} $sf_arr = explode(",", $text);foreach($sf_arr as $val){echo '"'.$val.'",';} //侧边栏第几个模块浮动 ?>],
            ajaxpager: '<?php if ($this->options->infpage == 'disable'): ?>0<?php else: ?>1<?php endif; ?>'
        };
    </script>
    <script type='text/javascript' src='<?php $this->options->themeUrl('css/bootstrap.min.js '); ?>'></script>
    <script type='text/javascript' src='<?php $this->options->themeUrl('js/loader.js'); ?>'></script>
    <!-- Analytics code -->
<?php if($this->options->GoogleAnalytics): ?>
    <?php $this->options->GoogleAnalytics(); ?>
<?php endif; ?>
</body>
</html>
