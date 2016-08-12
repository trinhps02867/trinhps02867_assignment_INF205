<?php

/**
 * Google Map API
 * 
 * @package FPOLY
 * @link http://vietframework.com
 * @copyright (c) 2016
 */

namespace app\extension\vuongminh;

use Yii;
use yii\base\Widget;
use app\extension\dosamigos\LatLng;
use app\extension\dosamigos\Map;
use yii\helpers\ArrayHelper;

/**
 * @author Vương Xương Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 * 
 */
class BanDo extends Widget {

    private $_tuyenDuong = [];
    public $chieuCao = 512;
    public $chieuDai = 512;
    public $viDo = 10.724088; //latitude
    public $kinhDo = 106.628626; // longitude
    public $phongTo = 14;

    /**
     *
     * @var Map
     */
    private $_bangDo;

    /**
     * Ví dụ
     * [
     *      'kinhDo' => 106.628626,
     *      'viDo' => 10.724088
     *      'phongTo' => 14,
     *      'chieuCao' => 512,
     *      'chieuDai' => 512,
     *      'thuocTinh' => [
     *           'class' => 'a'
     *      ]
     * ]
     * @param array $thietLap
     * @return BangDo
     */
    public static function khoiTao($thietLap = []) {
        /* @var $doiTuong GoogleMap */
        $thuocTinh = ArrayHelper::remove($thietLap, "thuocTinh");
        $doiTuong = static::begin($thietLap);
        $doiTuong->_bangDo = new Map([
            'center' => new LatLng(['lat' => $doiTuong->viDo, 'lng' => $doiTuong->kinhDo]),
            'zoom' => $doiTuong->phongTo,
        ]);
        $doiTuong->_bangDo->containerOptions = $thuocTinh;
        $doiTuong->_bangDo->width = $doiTuong->chieuDai;
        $doiTuong->_bangDo->height = $doiTuong->chieuCao;
        return $doiTuong;
    }

    public static function hienThi() {
        return static::end();
    }

    public function run() {
        foreach ($this->_tuyenDuong as $tuyenDuong) {
            $this->_bangDo->addOverlay($tuyenDuong);
        }
        return $this->_bangDo->display();
    }

    /**
     * 
     * @param string $moTa
     * @param string $maMau
     * @return TuyenDuong
     */
    public function themTuyenDuong($moTa, $maMau = "#000") {
        return $this->_tuyenDuong[] = Yii::createObject([
                    'class' => TuyenDuong::className(),
                    'moTa' => $moTa,
                    'maMau' => $maMau,
                    'bangDo' => $this->_bangDo
        ]);
    }



}
