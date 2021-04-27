<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite4d599947ef3f1bba040c0031d2133f8
{
    public static $files = array (
        'd5fa61a7f6cbc1df09dd4df84549a2dc' => __DIR__ . '/..' . '/rospdf/pdf-php/src/Cpdf.php',
        '2d15964294879de66053d54f6bde65d7' => __DIR__ . '/..' . '/rospdf/pdf-php/src/Cezpdf.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite4d599947ef3f1bba040c0031d2133f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite4d599947ef3f1bba040c0031d2133f8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite4d599947ef3f1bba040c0031d2133f8::$classMap;

        }, null, ClassLoader::class);
    }
}