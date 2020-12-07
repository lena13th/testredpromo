<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Главная';

$session = \Yii::$app->session;
if (!($session->isActive)) {
    $session->open();
}
$favorites = $session['favorites'];
?>

    <br/>
    <h3>Новости</h3>
    <br/>
    <?php if (!empty($news)): ?>

    <?php
    $num_news = 0; $first_row_bool=true; $count_not_public=0;
    foreach ($news as $key => $item_news):?>

        <?php
        if ($first_row_bool) {
            if (!($num_news % 3)) {
                echo '<div class="row">';
            }
        }
        ?>
        <?php
            $fav_news_public = 0;
            if (isset($favorites[$item_news->id])) {
                if ($favorites[$item_news->id]==1){
                    $fav_news_public = 1;
                }
            } else {
                if ($item_news->favorites==1){
                    $fav_news_public = 1;
                }
            }
            if ($fav_news_public==0){
                if ($first_row_bool){
                    $first_row_bool = false;
                }
                $count_not_public++;
            }
            if ($fav_news_public==1):
                $num_news++;?>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-xs-8">
                        <h5 class="date_news"><?= Yii::$app->formatter->asDate($item_news->date); ?></h5>
                    </div>
                    <div class="col-xs-4">
                        <a href="<?= Url::to(['news/favorites', 'id'=>$item_news->id])  ?>"
                           class="favorites_link favorites_link_active"
                           data-id="<?=$item_news->id ?>"
                        >
                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <a href="<?= Url::to(['/news/view', 'id' => $item_news->id]) ?>" class="link-titlenews"><h4 class="text-justify"><?= $item_news->title ?></h4></a>
                    </div>
                </div>
                <img class="main_article_image" src="<?= $item_news->img?>">
                <p class="text-justify"><?= $item_news->description ?></p>
                <p><a class="btn btn-primary" href="<?= Url::to(['/news/view', 'id' => $item_news->id]) ?>"
                      role="button">Подробнее...</a></p>
            </div>
        <?php endif; ?>
        <?php
        $n = $num_news-1;
        if (($n % 3 ==2) || ($n == count($news)-1-$count_not_public)) {
            echo '</div><br>';
        }
        ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php
        if ((count($news) == $count_not_public)||(empty($news))) {
            echo '<p>Нет избранных новостей</p><br>';
        }
    ?>
    <br />
    <p><a class="link" href="<?= Url::to(['/news/index']) ?>" role="button">Все новости &raquo;</a></p>
