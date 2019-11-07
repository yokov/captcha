<?php

require __DIR__ .'/../src/CaptchaBuilder.php';
require __DIR__ .'/../src/library/CharBuilder.php';
require __DIR__ .'/../src/library/GIFEncoder.php';
require __DIR__ .'/../src/library/ImageBuilder.php';


$config = [
    // 验证码字符类型
    'charType'          => 'default',
    // 验证码长度
    'length'            => 4,
    // 是否是 gif 动态图
    'isGif'             => false,
    // 动图帧率
    'gifFps'            => 12,
    // 图片宽度
    'width'             => 150,
    // 图片高度
    'height'            => 40,
    // 字体文件路径
    'fontPath'          => '',
    // 字体大小
    'fontSize'          => 24,
];

$builder = new \Yokov\Captcha\CaptchaBuilder($config);

// 获取验证码字符串
$builder->getChar();

// 生成验证码图片
$builder->build();

