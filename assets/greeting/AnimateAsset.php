<?php

namespace app\assets\greeting;

use yii\web\AssetBundle;
use yii\web\View;

class AnimateAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/greeting/assets';

    public $js = [
        'anime.min.js',
        'index.js'
    ];

    public function init()
    {

        $this->jsOptions['position'] = View::POS_END;

        parent::init();

    }

}