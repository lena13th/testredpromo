<?php

namespace app\controllers;

use app\components\CityWidget;
use app\models\Cities;
use app\models\News;
use yii\data\Pagination;
use yii\web\Controller;

class NewsController extends Controller
{

    public function actionIndex()
    {
        $city_id = CityWidget::widget(['object'=>'id']);
        $query = News::find()
            ->innerJoinWith('cities')
            ->where(['cities.id' => $city_id])
            ->andWhere(['public' => 1])
            ->orderBy('date DESC');
        $pages = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>4,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $news = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', compact('news', 'pages'));
    }

    public function actionView($id)
    {
        $news = News::find()
            ->where(['public' => 1])
            ->andWhere(['id' => $id])->one();
        if (empty($news)) throw new \yii\web\HttpException(404, 'К сожалению такой новости не найдено.');

        $related_news = $news->relatedNews;

        return $this->render('view', compact( 'news', 'related_news'));
    }

    public function actionSearch()
    {
        $q = trim(\Yii::$app->request->get('q'));
        if (!$q){
            return $this->render('search');
        }
        $city_id = CityWidget::widget(['object'=>'id']);
        $query = News::find()
            ->innerJoinWith('cities')
            ->where(['cities.id' => $city_id])
            ->andWhere(['like', 'title', $q])
            ->orWhere(['cities.id' => $city_id])
            ->andWhere(['like', 'text', $q])
            ->orderBy('date DESC');
        $pages = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>4,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $result_search = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search', compact( 'result_search', 'pages', 'q'));

    }

    public function actionFavorites($id){
        $session = \Yii::$app->session;
        if (!($session->isActive)) {
            $session->open();
        }
        $favorites = $session['favorites'];
        if (isset($favorites[$id])){
            if ($favorites[$id]==1){
                $favorites[$id]=0;
            } else {
                $favorites[$id]=1;
            }
        } else {
            $favorites[$id]=1;
        };
        $session['favorites'] = $favorites;

        if(\Yii::$app->request->isAjax){
            return true;
        }
        return false;
    }
}
