<?php

/**
 * Builds a new captcha image
 *
 * @author Yokov <yokov666@gmail.com>
 */

namespace Yokov\Captcha;

use Yokov\Captcha\Library\CharBuilder;
use Yokov\Captcha\Library\ImageBuilder;

/**
 * Class CaptchaBuilder
 *
 * @property mixed  charType
 * @property mixed  length
 * @property mixed  isGif
 * @property mixed  gifFps
 * @property mixed  width
 * @property mixed  height
 * @property mixed  fontPath
 * @property mixed  fontSize
 *
 * @package Yokov\Captcha
 */
class CaptchaBuilder
{
    // 验证码配置
    protected $config = [
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

    // 验证码字符串
    private $char;


    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 使用 $this->name 获取配置
     * @param  string $name 配置名称
     * @return mixed    配置值
     */
    public function __get($name)
    {
        return $this->config[$name];
    }

    /**
     * 设置验证码配置
     * @param  string $name  配置名称
     * @param  string $value 配置值
     */
    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 检查配置
     * @access public
     * @param  string $name 配置名称
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * 生成验证码图片
     * */
    public function build()
    {
        $config = [
            'width'             => $this->width,
            'height'            => $this->height,
            'char'              => $this->getChar(),
            'fontPath'          => $this->fontPath,
            'fontSize'          => $this->fontSize,
            'isGif'             => $this->isGif,
            'gifFps'            => $this->gifFps,
        ];

        return (new ImageBuilder($config))->build();

    }

    /**
     * 获取验证码字符串
     */
    public function getChar()
    {

        empty($this->char) && $this->char = (new CharBuilder($this->length, $this->charType))->build();

        return $this->char;
    }

}
