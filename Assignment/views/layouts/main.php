<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Metro Maps', 'url' => ['/map']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
//            ['label' => 'Profile ( Log in only )', 'url' => ['/driver/view']],
            ['label' => 'Login Only','items' => [
                ['label' => 'Driver', 'url' => ['/driver']],
                ['label' => 'Vehicle', 'url' => ['/vehicle']],
                ['label' => 'Line', 'url' => ['/line']],
                ['label' => 'Station', 'url' => ['/station']],
            ]],

            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3 mini-footer">
                <h4>Thông tin</h4>
                <ul>
                    <li>
                        <?= Html::a('Trang chủ',['/site/index']) ?>
                    </li>
                    <li>
                        <?= Html::a('Liên hệ',['/site/contact']) ?>
                    </li>
                    <li>
                        <?= Html::a('Bản đồ tuyến đường',['/map']) ?>
                    </li>
                    <li>
                        <?= Html::a('Giới thiệu về Metro',['/site/contact']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 mini-footer">
                <h4>Chính sách</h4>
                <ul>
                    <li>
                        <?= Html::a('Chính sách thành viên',['']) ?>
                    </li>
                    <li>
                        <?= Html::a('Chính sách khách hàng thân thiết',['']) ?>
                    </li>
                    <li>
                        <?= Html::a('Chính sách in hóa đơn VAT 5%',['']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 mini-footer">
                <h4>Quy định khách hàng</h4>
                <ul>
                    <li>
                        <?= Html::a('Quy định đổi - trả vé',['']) ?>
                    </li>
                    <li>
                        <?= Html::a('Hướng dẫn đặt mua và thanh toán online',['']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 mini-footer social">
                <h4>Kết nối với Metro Saigon thông qua</h4>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/">
                            <?= Html::img('public/images/Facebook.png',['style'=>'width:80px']) ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/">
                            <?= Html::img('public/images/Twitter.png',['style'=>'width:80px']) ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.pinterest.com/">
                            <?= Html::img('public/images/Pinterest.png',['style'=>'width:80px']) ?>
                        </a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/">
                            <?= Html::img('public/images/Google Plus.png',['style'=>'width:80px']) ?>
                        </a>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" action="" c style="margin: 10px 0px 0px 50px">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Subscribe Us" >
                    </div>
                    <button type="submit" class="btn btn-success">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
