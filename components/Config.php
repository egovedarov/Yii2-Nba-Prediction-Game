<?php

namespace app\components;

class Config
{
    public static function fromAlias($alias, array $context = [], $newThis = null)
    {
        $file = \Yii::getAlias($alias);
        return self::fromFile($file, $context, $newThis);
    }

    public static function fromFile($file, array $context = [], $newThis = null)
    {
        return (new self())->createClosure($file, $context, $newThis);
    }

    protected function createClosure($file, array $context = [], $newThis = null)
    {
        // Create scope for require.
        $func = function () use ($file, $context) {
            extract($context);
            return require($file);
        };

        $func = $func->bindTo($newThis, $newThis);
        return $func();
    }
}