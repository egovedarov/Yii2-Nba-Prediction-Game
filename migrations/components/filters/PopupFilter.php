<?php

namespace app\components\filters;

use yii\base\InvalidConfigException;
use yii\web\Response;

class PopupFilter extends LayoutFilter
{
    const RELOAD = 'reload';
    const FOLLOW = 'follow';

    public $allowedLayouts = [
        'popup'
    ];

    /**
     * Config array, [actionId  => method]
     * @var array
     */
    public $onRedirect = [];

    public function afterAction($action, $result)
    {
        if (
            isset($this->onRedirect[$this->getActionId($action)])
            && in_array(trim($action->controller->layout, '/'), $this->allowedLayouts)
            && $result instanceof Response
            && $result->getStatusCode() == 302
        ) {

            switch ($this->onRedirect[$this->getActionId($action)]) {
                case self::RELOAD:
                    $js = 'parent.location.reload();';
                    break;
                case self::FOLLOW:
                    $js = 'parent.location.href="' . $result->getHeaders()->get('Location') . '";';
                    break;
            }

            $allJs = <<<JS

if (typeof parent.showLoader !== 'undefined') {
    parent.showLoader();
}
if (typeof parent.hidePopup !== 'undefined') {
    parent.hidePopup();
}
JS;
            $allJs .= $js ?? '';

            return new Response([
                'content' => '<html><script>' . $allJs . '</script></html>'
            ]);
        }

        return parent::afterAction($action, $result);
    }

    public function init()
    {
        parent::init();
        $allowedMethods = [
            self::FOLLOW => true,
            self::RELOAD => true
        ];
        foreach ($this->onRedirect as $actionId => $method) {
            if (!isset($allowedMethods[$method])) {
                throw new InvalidConfigException('Unknown on redirect method');
            }
        }
    }
}