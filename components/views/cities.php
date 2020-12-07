<?php

use yii\helpers\Url;

foreach ($cities as $city) {
?>
    <li><a href="<?= Url::to(['site/city', 'id'=>$city->id])  ?>"><?= $city->name ?></a></li>

<?php
}
?>