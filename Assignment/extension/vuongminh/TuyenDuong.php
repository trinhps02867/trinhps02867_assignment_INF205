<?php

/**
 * Google Map API
 * 
 * @package FPOLY
 * @link http://vietframework.com
 * @copyright (c) 2016
 */

namespace app\extension\vuongminh;

use app\extension\dosamigos\Map;
use app\extension\dosamigos\LatLng;
use app\extension\dosamigos\overlays\InfoWindow;
use app\extension\dosamigos\overlays\Marker;
use app\extension\dosamigos\overlays\Polyline;
use app\extension\dosamigos\overlays\Animation;

/**
 * @author Vương Xương Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 * 
 */
class TuyenDuong extends Polyline {

    /**
     *
     * @var string
     */
    public $moTa;

    /**
     *
     * @var string
     */
    public $maMau;

    /**
     *
     * @var Map 
     */
    public $bangDo;

    public function init() {
        $this->strokeColor = $this->maMau;
        $this->attachInfoWindow(
                new InfoWindow(['content' => "<p>{$this->moTa}</p>"])
        );
    }

    /**
     * 
     * @param array $toaDo | Ví dụ: ["viDo" => 1, "kinhDo" => 1]
     * @param type $moTa | Ví dụ: suoi tien
     * @param type $hinhAnh | Ví dụ: http://abc.com/a.jpg
     * @return \app\extension\vuongminh\TuyenDuong
     */
    public function themTram(array $toaDo, $moTa = "", $hinhAnh = "") {
        $doiTuongToaDo = new LatLng([
            'lat' => $toaDo["viDo"],
            'lng' => $toaDo["kinhDo"]
        ]);
        $this->addCoord($doiTuongToaDo);
        $marker = new Marker([
            'position' => $doiTuongToaDo,
            'icon' => $hinhAnh,
            'animation' => Animation::DROP,
//            'title' => $moTa,
        ]);
        $marker->attachInfoWindow(
                new InfoWindow([
            'content' => "<p>$moTa</p>"
                ])
        );
        $this->bangDo->addOverlay($marker);
        return $this;
    }

    /**
     * 
     * @param array $toaDo | Ví dụ: ["viDo" => 1, "kinhDo" => 1]
     */
    public function themDiem(array $toaDo) {
        $doiTuongToaDo = new LatLng([
            'lat' => $toaDo["viDo"],
            'lng' => $toaDo["kinhDo"]
        ]);
        $this->addCoord($doiTuongToaDo);
    }

}
