<?php
/**
 * Created by PhpStorm.
 * User: LEO
 * Date: 14/06/2016
 * Time: 6:05 PM
 */

//$tram1 = '<strong>Bến Thành</strong>';
use app\extension\vuongminh\BanDo;
use yii\helpers\Url;
$this->title = 'Saigon Metro Maps - PS02867';

$banDo = BanDo::khoiTao([
    'kinhDo' => 106.697991,
    'viDo' => 10.772556,
    'chieuDai' => 1024,
    'chieuCao' => 500,
    'thuocTinh' => [
        'style' => ['float: right;margin-top:100px;margin-bottom:100px;'],
        'class' => [],
    ]
]);
$tuyen1 = $banDo->themTuyenDuong("Bến Thành - Suối Tiên", "red");
$tuyen1->themTram([
    'kinhDo' => 106.697991,
    'viDo' => 10.772556,
], 'Bến Thành',Url::to('public/images/google-pin-red.png'));
$tuyen1->themTram([
    'kinhDo' => 106.733213,
    'viDo' => 10.801536,
], 'Thảo Điền',Url::to('public/images/google-pin-red.png'));
$tuyen1->themTram([
    'kinhDo' => 106.801431,
    'viDo' => 10.866135,
], 'Suối Tiên',Url::to('public/images/google-pin-red.png'));

?>
<div class="container" style="margin: auto;">
    <div class="row">
        <?php
        BanDo::hienThi();
        ?>
    </div>
</div>
