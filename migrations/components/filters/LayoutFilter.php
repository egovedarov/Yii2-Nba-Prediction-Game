<?php

namespace app\components\filters;

use yii\base\ActionFilter;

class LayoutFilter extends ActionFilter
{
    public $allowedLayouts = [];

    public function beforeAction($action)
    {
        $request = $action->controller->module->get('request');
        if ($request && $layout = $request->getQueryParam('layout')) {
            if (in_array($layout, $this->allowedLayouts)) {
                $action->controller->layout = '//' . $layout;
            }
        }
        return true;
    }
}