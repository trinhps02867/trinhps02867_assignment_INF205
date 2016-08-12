<?php
/**
 * Created by PhpStorm.
 * User: LEO
 * Date: 14/06/2016
 * Time: 6:04 PM
 */
namespace app\controllers;

use yii\web\Controller;

class MapController extends Controller
{
    public function actionIndex()
    {
        return $this->render('map');
    }
}