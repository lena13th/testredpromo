<?php

use yii\helpers\Url;
$this->title = $news->title;

$session = \Yii::$app->session;
if (!($session->isActive)) {
    $session->open();
}
$favorites = $session['favorites'];

?>

<br>
<div class="row">
    <div class="col-xs-8">
        <h5 class="date_news"><?= Yii::$app->formatter->asDate($news->date); ?></h5>
    </div>
    <div class="col-xs-4">
        <?php
        $favorites_news=0;
        if (isset($favorites[$news->id])){
            if ($favorites[$news->id]==1){ $favorites_news=1;}
        } else {
            if ($news->favorites==1){ $favorites_news=1;}
        } ?>

        <a href="<?= Url::to(['news/favorites', 'id'=>$news->id])  ?>"
           class="btn favorites_button <?php if ($favorites_news==0) echo 'btn-warning'; else echo 'favorites_button_active'?>"
           data-id="<?=$news->id ?>"
        >
            <?php if ($favorites_news==0) echo 'Добавить в избранное'; else echo 'Убрать из избранного'?>
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        </a>

    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h2><?= $news->title ?></h2>
    </div>
</div>
<div class="row text-center">
    <img class="main_article_image_lg" src="<?= $news->img?>">
</div>
<br>
<p class="lead text-justify"><?= $news->text ?></p>

<?php if (!empty($related_news)): ?>

<hr>
<h3>Похожие новости</h3>

<?php foreach ($related_news as $key => $item_related_news):?>

<?php
    if ($key % 3==0) {
        echo '<div class="row">';
    } ?>

    <div class="col-md-4">
        <div class="row">
            <div class="col-xs-8">
                <h5 class="date_news"><?= Yii::$app->formatter->asDate($item_related_news->date); ?></h5>
            </div>
            <div class="col-xs-4">
                <a href="<?= Url::to(['news/favorites', 'id'=>$item_related_news->id])  ?>"
                   class="favorites_link
                   <?php if (isset($favorites[$item_related_news->id])){
                       if ($favorites[$item_related_news->id]==1){ echo 'favorites_link_active';}
                   } else {
                       if ($item_related_news->favorites==1){ echo 'favorites_link_active';}
                   } ?> "
                   data-id="<?=$item_related_news->id ?>"
                >
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="<?= Url::to(['/news/view', 'id' => $item_related_news->id]) ?>" class="link-titlenews"><h4 class="text-justify"><?= $item_related_news->title ?></h4></a>
            </div>
        </div>
    </div>
<?php
    if (($key % 3 ==2) || ($key == count($related_news)-1)) {
        echo '</div>';
    }
?>
    <?php endforeach; ?>

    <hr>
<?php endif; ?>