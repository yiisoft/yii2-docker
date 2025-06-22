<?php

namespace app\modules\api\v1\controllers;

use app\models\Track;
use yii\rest\ActiveController;
use yii\data\ActiveDataFilter;
use yii\filters\auth\HttpBearerAuth;
use Yii;

/**
 * TrackController implements the REST Api actions for Track model.
 */
class TrackController extends ActiveController
{
    public $modelClass = 'app\models\Track';
    public $createScenario = Track::SCENARIO_CREATE;
    public $updateScenario = Track::SCENARIO_UPDATE;

    public function actionBulkupdate(): array
    {
        $request = Yii::$app->request->getBodyParams();
        Yii::info(['Query params: '.print_r(Yii::$app->request->getQueryParams(), 1)]);
        $updatedModels = [];
        foreach ($request as $value) {
            Yii::$app->request->setBodyParams($value);
            $updatedModels[] = $this->runAction('update', $value);
        }
        Yii::$app->request->setBodyParams($request);
        return $updatedModels;
    }

    public function actions(): array
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => ActiveDataFilter::class,
            'searchModel' => $this->modelClass,
        ];

        return $actions;
    }

    public function behaviors(): array
    {
        $behaviours = parent::behaviors();
        $behaviours['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviours;
    }
}
