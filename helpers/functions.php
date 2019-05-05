<?php
/**
 * Some helper functions in the global namespace.
 */

/**
 * @return \app\components\WebApplication|\yii\console\Application
 */
function app()
{
    return \Yii::$app;
}

/**
 * Helperfunction for debugging.
 */
function vd($arg, $depth = 10, $highlight = true, $skip = 0) {
    if (defined('YII_DEBUG') && YII_DEBUG) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $skip + 2);
        $details = $trace[$skip + 1];
        $file = $trace[$skip]['file'];
        $line = $trace[$skip]['line'];

        $class = \yii\helpers\ArrayHelper::getValue($details, 'class', 'Global function');

        $token = "{$class}::{$details['function']}, ({$file}:{$line})";
        if (defined('CONSOLE') && !CONSOLE) {
            echo \kartik\helpers\Html::well("Dumped from: " . $token . '<br>' . \app\components\VarDumper::dumpAsString($arg,
                    $depth, $highlight), \kartik\helpers\Html::SIZE_LARGE, [
                'style' => 'text-align: left;'
            ]);
        } else {
            echo "Dumped from: $token\n";
            var_dump($arg);
        }
    }
    
    return $arg;
}

function vdd($var, $message = '', $depth = 10, $highlight = true) {
    vd($var, $depth = 10, $highlight, 1);
    die($message);
}

function toSql(\yii\db\Query $query)
{
    return $query->prepare(app()->db->queryBuilder)->createCommand()->rawSql;
}

function vdSql(\yii\db\Query $query, $depth = 10, $highlight = true)
{
    vd(toSql($query), $depth, $highlight, 1);
}

function vddSql(\yii\db\Query $query, $message = '', $depth = 10, $highlight = true)
{
    vdd(toSql($query), $message, $depth, $highlight);
}

function randomString($length)
{
    // we are using only this characters/numbers in the string generation
    $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $string =''; // define variable with empty value
    // we generate a random integer first, then we are getting corresponding character , then append the character to $string variable. we are repeating this cycle until it reaches the given length
    for($i=0;$i<$length; $i++)
    {
        $string .= $chars[rand(0,strlen($chars)-1)];
    }
    return $string ; // return the final string
}