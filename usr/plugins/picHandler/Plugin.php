<?php
/**
 * Typecho 每张图片先添加水印再压缩一下
 * 
 * @package picHandler
 * @author 张彦飞.allen
 * @version 0.0.1
 */
include_once "functions.php";

class picHandler_Plugin implements Typecho_Plugin_Interface {

    public static function activate() {
        Typecho_Plugin::factory('Widget_Upload')->upload = array('picHandler_Plugin', 'uploadHandle');
        // Typecho_Plugin::factory('Widget_Upload')->modify = array('picHandler_Plugin', 'render');
    }

    public static function deactivate(){
    }

    public static function config(Typecho_Widget_Helper_Form $form) {

        $waterMarkImg = new Typecho_Widget_Helper_Form_Element_Text('waterMarkImg', NULL, '/usr/plugins/picHandler/watermark.png', _t('水印路径（png，相对路径）'));
        $waterMarkPos = new Typecho_Widget_Helper_Form_Element_Text('waterMarkPos', NULL, '0', _t('水印位置（九宫格位置填写0-9，1-9为位置，0为随机。）'));
        $waterMarkAllow = new Typecho_Widget_Helper_Form_Element_Text('waterMarkAllow', NULL, 'jpg,png', _t('水印图片格式，直接填写格式以半角逗号分隔，gif加水印后会失去动画效果。'));
        $form->addInput($waterMarkImg);
        $form->addInput($waterMarkPos);
        $form->addInput($waterMarkAllow);
        
        $compress_larger = new Typecho_Widget_Helper_Form_Element_Text('compress_larger', NULL, '50',
            _t('图片压缩大小阈值'), _t('当图片大小超过此值（单位：KB）时，对图片进行压缩。（仅压缩 jpg 和 png ）<br/>
如果使用云主机，须安装 <code>jpegoptim</code> 和 <code>pngquant</code>，不要填 TinyPNG API Key！<br/>
Ubuntu 系统下安装方法：<code>sudo apt install jpegoptim pngquant</code>'));
        $form->addInput($compress_larger);
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    public static function uploadHandle($img){
        self::addWaterMark($img);
        self::compressImage($img);
    }
    
    public static function addWaterMark($img){
        if (!$img->attachment->isImage){
            return;
        }

        $srcImg = __TYPECHO_ROOT_DIR__ . $img->attachment->path;
            
        // 有水印
        $waterMarkImg = Typecho_Widget::widget('Widget_Options')->plugin('picHandler')->waterMarkImg;
        $waterMarkPos = Typecho_Widget::widget('Widget_Options')->plugin('picHandler')->waterMarkPos;
        $waterMarkAllow = Typecho_Widget::widget('Widget_Options')->plugin('picHandler')->waterMarkAllow;
        $waterMarkquality = 100;
        $type = $img->attachment->type;
                
        if ($type == 'jpeg') {
            $type = 'jpg';
        }

        if (stripos($waterMarkAllow,$type) !== false){
            $waterImg = __TYPECHO_ROOT_DIR__ . $waterMarkImg;
            if (rename($srcImg,$srcImg.'.tmp')){
                $destImg = $srcImg;
                $srcImg = $srcImg.'.tmp';
                require_once("imgfunc.php");
                ImgWaterMark($waterMarkquality, 100, "", 1,$srcImg,$waterMarkPos,$waterImg, '', 12, '#FF0000', $destImg);
                unlink($srcImg);
            }
        }
    }
    
    
    public static function compressImage($img){
         if (!$img->attachment->isImage){
            return;
        }

        $path = __TYPECHO_ROOT_DIR__ . $img->attachment->path;
        self::compress($path);
        
        $ext = strtolower(pathinfo($path)['extension']);
        $file['size'] = filesize($path);
        
         //返回相对存储路径
        return array(
            'name' => $file['name'],
            'path' => __TYPECHO_ROOT_DIR__,
            'size' => $file['size'],
            'type' => $ext,
            'mime' => Typecho_Common::mimeContentType($path)
        );
    }
    
    /**
     * 压缩图片
     *
     * @param $path
     * @throws Exception
     */
    public static function compress(&$path)
    {
        var_dump($path);
        $ext = strtolower(pathinfo($path)['extension']);
        if ($ext === "png") {
            compress_png_inplace($path);
        } elseif ($ext === "jpg" || $ext === "jpeg") {
            compress_jpg_inplace($path);
        }
        // 清除文件信息缓存，以获得正确的图片大小
        clearstatcache();
    }
}

