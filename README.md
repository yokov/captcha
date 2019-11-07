# captcha

##### 一个 PHP 验证码库


### 安装

```shell
$ composer require yokov/captcha -vvv
```

### 使用

```php
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
```

### 部分设置

* 验证码字符类型
  1. default: 大小写字母和数字混合
  2. only_char: 只有大小写字母
  3. only_number: 只有数字
  
* 字体文件
  * _注：可自定义字体文件，fontPath 配置相应的字体文件路径即可_

  * _库中内置 9 种字体(fontPath 设置 1-9 可分别指定相应的字体)_
  
  | 字体序号 | 静态样式 | 动图 |
  | :----: | :----: | :----: |
  | 1 | ![font-1](demo/image/1.gif) | ![gif-font-1](demo/image/animation/1.gif) |
  | 2 | ![font-2](demo/image/2.gif) | ![gif-font-2](demo/image/animation/2.gif) |
  | 3 | ![font-3](demo/image/3.gif) | ![gif-font-3](demo/image/animation/3.gif) |
  | 4 | ![font-4](demo/image/4.gif) | ![gif-font-4](demo/image/animation/4.gif) |
  | 5 | ![font-5](demo/image/5.gif) | ![gif-font-5](demo/image/animation/5.gif) |
  | 6 | ![font-6](demo/image/6.gif) | ![gif-font-6](demo/image/animation/6.gif) |
  | 7 | ![font-7](demo/image/7.gif) | ![gif-font-7](demo/image/animation/7.gif) |
  | 8 | ![font-8](demo/image/8.gif) | ![gif-font-8](demo/image/animation/8.gif) |
  | 9 | ![font-9](demo/image/9.gif) | ![gif-font-9](demo/image/animation/9.gif) |


### License

BSD
