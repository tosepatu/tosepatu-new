<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit72b9a4b3ea04ba5fdcb3d0bc927d21ac
{
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit72b9a4b3ea04ba5fdcb3d0bc927d21ac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit72b9a4b3ea04ba5fdcb3d0bc927d21ac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit72b9a4b3ea04ba5fdcb3d0bc927d21ac::$classMap;

        }, null, ClassLoader::class);
    }
}
