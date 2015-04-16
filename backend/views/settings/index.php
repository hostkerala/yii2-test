<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;



/* @var $this yii\web\View */
$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?=  $this->title ?></h3>
<hr />
<?php
$countryUrl = Url::to(['country/index']);
$stateUrl =  Url::to(['states/index']);
$cityUrl =  Url::to(['zipareas/index']);
$catUrl =  Url::to(['categories/index']);

echo Tabs::widget([
    'items' => [
        [
            'label' => 'General Settings', 
            'icon' => 'user',
            'content' => '<br />
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="'.$countryUrl.'"><button type="button" class="btn btn-primary">Country Management</button></a>
                                <a href="'.$stateUrl.'"><button type="button" class="btn btn-info">State Management</button></a>
                                <a href="'.$cityUrl.'"><button type="button" class="btn btn-success">City Management</button></a>
                                <a href="'.$catUrl.'"><button type="button" class="btn btn-warning">Category Management</button></a>
                            </div>
                        <br />',
            'active' => true
        ],
        [
            'label' => 'Advanced Settings',
            'content' => 'Advanced Settings',
            //'headerOptions' => [...],
            'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'All Settings',
            'content' => 'All Settings',
            
        ],
    ],
]);
?>    

