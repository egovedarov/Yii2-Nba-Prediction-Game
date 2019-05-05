<?php

namespace app\controllers;

use app\components\filters\LayoutFilter;
use SamIT\Yii2\Traits\ActionInjectionTrait;
use yii\helpers\ArrayHelper;

class Controller extends \yii\web\Controller
{
    use ActionInjectionTrait;

    public function behaviors()
    {
        return ArrayHelper::merge([
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin'],
//                    ],
//                    [
//                        'allow' => false,
//                    ]
//                ]
//            ],
            LayoutFilter::class => [
                'class' => LayoutFilter::class,
                'allowedLayouts' => [
                    'popup'
                ]
            ]
        ], parent::behaviors());
    }
}