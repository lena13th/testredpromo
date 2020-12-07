<?php

namespace app\controllers;

use app\components\CityWidget;
use app\models\Cities;
use app\models\News;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $limit_news = 3;

        $session = \Yii::$app->session;
        if (!($session->isActive)) {
            $session->open();
        }
        $favorites = $session['favorites'];
        $fav_ses_true_ids=[];
        if (isset($favorites)){
            foreach ($favorites as $key => $favorites_item) {
                if ($favorites_item ==1){
                    $fav_ses_true_ids[] = $key;
                }
            }
        }
        $city_id = CityWidget::widget(['object'=>'id']);

        if (count($fav_ses_true_ids)>=6) {
            $news = News::find()
                ->innerJoinWith('cities')
                ->where(['cities.id' => $city_id])
                ->andWhere(['public' => 1])
                ->andWhere(['in', 'news.id', $fav_ses_true_ids])
                ->orderBy('date DESC')
                ->limit($limit_news)->all();
        } else {
            $news = News::find()
                ->innerJoinWith('cities')
                ->where(['cities.id' => $city_id])
                ->andWhere(['public' => 1])
                ->andWhere(['in', 'news.id', $fav_ses_true_ids])
                ->orderBy('date DESC')
                ->limit($limit_news)->all();
            $limit = $limit_news - count($news);
            $news_fav_db = News::find()
                ->innerJoinWith('cities')
                ->where(['cities.id' => $city_id])
                ->andWhere(['public' => 1])
                ->andWhere(['favorites'=>1])
                ->andWhere(['not in', 'news.id', $fav_ses_true_ids])
                ->orderBy('date DESC')
                ->limit($limit)->all();
            foreach ($news_fav_db as $item_news) {
                if ($item_news->favorites == 1){
                    if (!isset($favorites[$item_news->id])) {
                        $favorites[$item_news->id] = 1;
                    }
                }
                $news[] = $item_news;
            }
        }
        $session['favorites'] = $favorites;

        return $this->render('index', compact('news'));
    }

    public function actionCity($id){
        $session = \Yii::$app->session;
        if (!($session->isActive)) {
            $session->open();
        }
        $city = Cities::find()->where(['id' => $id])->one();
        $session['city'] = $city;
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

}
