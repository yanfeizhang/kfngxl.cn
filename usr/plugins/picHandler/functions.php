<?php
/**
 *  PNG压缩，覆盖原图片。需要安装pngquant
 *
 * @param $png_path
 * @param int $max_quality
 * @return string|null
 */
function compress_png_inplace($png_path, $max_quality = 90)
{
    $min_quality = 60;
    return shell_exec("pngquant --skip-if-larger --ext .png --force --quality=$min_quality-$max_quality $png_path");
}

/**
 * JPG压缩，覆盖原图片。需要安装jpegoptim
 *
 * @param $jpg_path
 * @param int $max_quality
 * @return string|null
 */
function compress_jpg_inplace($jpg_path, $max_quality = 90)
{
    return shell_exec("jpegoptim --max=$max_quality --preserve --all-progressive $jpg_path");
}

/**
 * BMP转JPG。需要安装imagemagick
 *
 * @param $bmp_path
 * @return mixed
 */
function convert_bmp_to_jpg($bmp_path) {
    $info = pathinfo($bmp_path);
    $jpg_path = $info['dirname'] . '/' . $info['filename'] . '.jpg';
    if (shell_exec("convert $bmp_path $jpg_path")) {
        return $jpg_path;
    }
    return false;
}
