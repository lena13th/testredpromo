<?php

namespace app\components;
use app\models\Cities;
use yii\base\Widget;

class CitiesWidget extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $session = \Yii::$app->session;
        if (!($session->isActive)) {
            $session->open();
        }

        $cities = Cities::find()->orderBy('name ASC')->all();
        if (!isset($session['city'])){
            $session['city'] = $cities[0];
        }
        return $this->render('cities', compact('cities'));
    }


}

