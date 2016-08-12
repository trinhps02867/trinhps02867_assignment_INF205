<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace app\extension\dosamigos\overlays;


/**
 * Animation
 *
 * Animations that can be played on a marker. Use the setAnimation method on a [app\extension\dosamigos\overlays\Marker]
 * or the animation option to play an animation.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package app\extension\dosamigos\overlays
 */
class Animation
{
    const DROP = 'google.maps.Animation.DROP';
    const BOUNCE = 'google.maps.Animation.BOUNCE';

    /**
     * Checks whether value is a valid [Animation] constant.
     *
     * @param $value
     *
     * @return bool
     */
    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::DROP,
                static::BOUNCE
            ]
        );
    }
} 