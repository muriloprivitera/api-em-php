<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit160fc6a14d01f430228a30f9b9091e9f
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cadastroTarefasApi\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cadastroTarefasApi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../cadastroTarefas/api',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit160fc6a14d01f430228a30f9b9091e9f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit160fc6a14d01f430228a30f9b9091e9f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit160fc6a14d01f430228a30f9b9091e9f::$classMap;

        }, null, ClassLoader::class);
    }
}
