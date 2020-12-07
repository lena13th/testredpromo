<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$session = \Yii::$app->session;
if (!($session->isActive)) {
    $session->open();
}
$favorites = $session['favorites'];

?>

<?php if (!empty($result_search)): ?>
    <br/>
    <h3>Результаты по запросу '<?= \yii\helpers\Html::encode($q) ?>':</h3>
    <br/>

    <?php foreach ($result_search as $key => $item_news): ?>
        <?php
        if (!($key % 2)) {
            echo '<div class="row">';
        }
        ?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-8">
                    <h5 class="date_news"><?= Yii::$app->formatter->asDate($item_news->date); ?></h5>
                </div>
                <div class="col-xs-4">
                    <a href="<?= Url::to(['news/favorites', 'id'=>$item_news->id])  ?>"
                       class="favorites_link
                           <?php if (isset($favorites[$item_news->id])){
                           if ($favorites[$item_news->id]==1){ echo 'favorites_link_active';}
                       } else {
                           if ($item_news->favorites==1){ echo 'favorites_link_active';}
                       } ?> "
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
            <p><a class="btn btn-primary" href="<?= Url::to(['/news/view', 'id' => $item_news->id]) ?>" role="button">Подробнее...</a></p>
        </div>
        <?php
        if (($key % 2) || ($key == count($result_search)-1)) {
            echo '</div><br>';
        }
        ?>
    <?php endforeach; ?>


    <nav style="text-align: center;">
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </nav>

<?php else: ?>
    <div class="empty_content empty_center">
        <div class="h2">Новостей не найдено</div>
        <p>К сожалению по запросу "<?= \yii\helpers\Html::encode($q) ?>" новостей не найдено</p>
        <a href="<?= Url::to(['/news/index']) ?> " class="btn btn-default back_to_home"><span>Вернуться к списку новостей</span></a>
    </div>
<?php endif; ?>

