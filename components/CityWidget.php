<?php

namespace app\components;
use app\models\Cities;
use yii\base\Widget;

class CityWidget extends Widget{

    public $object;
    public $city;

    public function init() {
	    parent::init();
        $session = \Yii::$app->session;
        if (!($session->isActive)) {
            $session->open();
        }
		$this->city = $session['city'];
        if (!isset($session['city'])){
            $city = Cities::find()->orderBy('name ASC')->limit(1)->one();
            $this->city = $city;
        }
    }

	public function run() {
        switch ($this->object) {
            case 'id':
                return $this->city->id; break;
            case 'name':
                return $this->city->name; break;
        }

	}

}

