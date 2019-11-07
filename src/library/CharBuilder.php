<?php
/**
 *  Generates random code
 *
 * @author Yokov <yokov666@gmail.com>
 */

namespace Yokov\Captcha\Library;


class CharBuilder
{
    // 验证码字符集合
    protected $charset = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
    protected $onlyNumber = '0123456789';
    protected $onlyChar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected $length;

    public function __construct($length = 4, $charType = 'default')
    {
        $this->length = $length;
        $this->charType = $charType;

    }

    /**
     * 生成验证码字符串
     * @param int $length
     * @param null $charset
     * @return string
     */
    public function build(){

        $char = '';

        switch ($this->charType){
            case 'only_number':
                $this->charset = $this->onlyNumber;
                $char = $this->getChar();
                break;
            case 'only_char':
                $this->charset = $this->onlyChar;
                $char = $this->getChar();
                break;
            default:
                $char = $this->getChar();
        }

        return $char;
    }

    /**
     * 生成默认验证码字符串
     * @param int $length
     * @param null $charset
     * @return string
     */
    public function getChar(){

        $char = '';
        $chars = str_split($this->charset);

        for ($i = 0; $i < $this->length; $i++){
            $char .= $chars[array_rand($chars)];
        }

        return $char;
    }


}
