<?php
/**
 *  Generates image
 *
 * @author Yokov <yokov666@gmail.com>
 */

namespace Yokov\Captcha\Library;

/**
 * Class CaptchaBuilder
 *
 * @property mixed  width
 * @property mixed  height
 * @property mixed  char
 * @property mixed  fontPath
 * @property mixed  fontSize
 * @property mixed  isGif
 * @property mixed  gifFps
 *
 * @package Yokov\Captcha
 */
class ImageBuilder
{
    private $im;

    // 验证码配置
    protected $config = [
        // 图片宽度
        'width' => 150,
        // 图片高度
        'height' => 40,
        // 验证码字符串
        'char'              => '',
        // 字体文件路径
        'fontPath'          => '',
        // 字体大小
        'fontSize'          => 24,
        // 是否是 gif 动态图
        'isGif'             => false,
        // 动图帧率
        'gifFps'            => 12,
    ];

    // 验证码长度
    private $length;
    // 验证码字体颜色
    private $textColor = array();


    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $this->length = mb_strlen($this->char, 'utf-8');
        $this->textColor = array(mt_rand(1,150), mt_rand(1,150), mt_rand(1,150));
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

    public function build()
    {
        if ($this->isGif){
            $image =  $this->buildGif();
        }else{
            $image = $this->buildImg($this->char);
        }

        Header ('Content-type:image/gif');
        echo $image;
        exit;

    }

    private function buildGif()
    {
        $imageData = [];
        for ($i = 0; $i < $this->gifFps; $i++){
            $imageData[] = $this->buildImg();
        }

        $gif = new GIFEncoder( $imageData, 9, 0, 2, 0, 0, 1);
        return $gif->GetAnimation();
    }

    /**
     * 生成图片
     * @return false|string
     */
    private function buildImg()
    {

        $this->createImage();
        $this->fillBackgroundColor();
        $this->drawEllipse();
        $this->drawLine();
        $this->writeChar();
        $this->distort();
        return $this->getImg();
    }

    /**
     * 获取图片
     */
    public function getImg()
    {
        ob_start();
        imagegif($this->im);
        imagedestroy($this->im);

        $img = ob_get_contents();
        ob_clean();

        return $img;
    }

    /**
     * 创建画布
     */
    private function createImage()
    {
        $this->im = imagecreatetruecolor($this->width, $this->height) or die("Cannot Initialize new GD image stream");
    }

    /**
     * 填充背景颜色
     */
    private function fillBackgroundColor()
    {
        $background_color = imagecolorallocate($this->im, 243, 251, 254);
        imagefill($this->im,0,0,$background_color);
    }

    /**
     * 写入字符串
     */
    private function writeChar()
    {
        $fontPath = $this->getFont();

        $box = imagettfbbox($this->fontSize, 0, $fontPath, $this->char);
        $textWidth = $box[2] - $box[0];
        $textHeight = $box[1] - $box[7];
        $x = ($this->width - $textWidth) / 2;
        $y = ($this->height - $textHeight) / 2 + $this->fontSize;

        $text_color = imagecolorallocate($this->im, $this->textColor[0], $this->textColor[1], $this->textColor[2]);

        for ($i = 0; $i < $this->length; $i++) {
            $box = imagettfbbox($this->fontSize, 0, $fontPath, $this->char[$i]);
            $w = $box[2] - $box[0];
            $offset = mt_rand(-5, 5);
            $angle = $this->isGif ? mt_rand(-5, 5) : mt_rand(-20, 20);
            imagettftext($this->im, $this->fontSize, $angle, $x, $y + $offset, $text_color, $fontPath, $this->char[$i]);
            $x += $w;
        }

    }

    /**
     * 画干扰线
     */
    protected function drawLine()
    {

        $Xa   = mt_rand(0, $this->width/4);
        $Ya   = mt_rand($this->height/4, $this->height/2);
        $Xb   = mt_rand($this->width/4*3, $this->width);
        $Yb   = mt_rand($this->height/2, $this->height/4*3);
        $text_color = imagecolorallocate($this->im, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
        imagesetthickness($this->im, mt_rand(2, 4));
        imageline($this->im, $Xa, $Ya, $Xb, $Yb, $text_color);
    }

    /**
     * 画椭圆背景
     */
    private function drawEllipse()
    {
        $ellipse_num = mt_rand(2, $this->length);
        for ($em = 0; $em < $ellipse_num; $em++){
            $ellipse_color = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imageellipse ($this->im , mt_rand(0, $this->width) , mt_rand(0, $this->height) , mt_rand(5, 30) , mt_rand(5, 30) , $ellipse_color );
        }
    }

    /**
     * 扭曲变形图片
     */
    private function distort()
    {
        $dst = imagecreatetruecolor($this->width, $this->height);
        $dWhite = imagecolorallocate($dst, 243, 251, 254);
        imagefill($dst,0,0,$dWhite);

        for($i = 0; $i < $this->width; $i++)
        {
            // 根据正弦曲线计算上下波动的posY
            $offset = 4; // 最大波动几个像素
            $round = 2; // 扭2个周期,即4PI
            $posY = round(sin($i * $round * 2 * M_PI / $this->width ) * $offset); // 根据正弦曲线,计算偏移量

            imagecopy($dst, $this->im, $i, $posY, $i, 0, 1, $this->height);
        }

        $this->im = $dst;
    }

    /**
     * 获取字体文件
     */
    private function getFont()
    {
        if (empty($this->fontPath)){
            $this->fontPath = __DIR__  . '/../font/' . mt_rand(1, 9) . '.ttf';
        }elseif (in_array($this->fontPath, [1, 2, 3, 4, 5, 6, 7, 8, 9])){
            $this->fontPath = __DIR__  . '/../font/' . $this->fontPath . '.ttf';
        }

        return $this->fontPath;

    }

}
