<?php

declare(strict_types=1);

namespace app\modules\api\v1;

/**
 * api1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
}
