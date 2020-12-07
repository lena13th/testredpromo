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

<?php if (!empty($news)): ?>
    <form class="form-horizontal" action="<?= Url::to(['/news/search'])?>" method="get">
        <div class="form-group form-group-lg">
            <div class="col-xs-6">
                <input type="text" name="q" class="search_input form-control" placeholder="Поиск по новостям"
                       aria-describedby="sizing-addon1"/>
            </div>
            <button type="submit" class="btn btn-lg">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>
        </div>
    </form>
    <br/>
    <h3>Новости</h3>
    <br/>
    <?php foreach ($news as $key => $item_news): ?>
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
                        <a href="<?= Url::to(['/news/view', 'id' => $item_news->id]) ?>" class="link-titlenews"><h3 class="text-justify"><?= $item_news->title ?></h3></a>
                    </div>
                </div>
                <img class="main_article_image" src="<?= $item_news->img?>">
                <p class="text-justify"><?= $item_news->description ?></p>
                <p><a class="btn btn-primary" href="<?= Url::to(['/news/view', 'id' => $item_news->id]) ?>" role="button">Подробнее...</a></p>
            </div>
        <?php
        if (($key % 2) || ($key == count($news)-1)) {
            echo '</div><br/>';

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
        <p>К сожалению на данный момент на сайте нет опубликованных новостей.</p>
        <a href="<?= Url::to(['/site/index']) ?> " class="btn btn-default back_to_home"><span>Вернуться на главную</span></a>
    </div>
<?php endif; ?>

