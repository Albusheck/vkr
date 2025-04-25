<?php

namespace app\assets\greeting;

use yii\web\AssetBundle;
use yii\web\View;

class GreetingAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/greeting/assets';

    public $js = [
        'tailwind.min.js',
    ];

    public $css = [
        'site.css',
    ];

    public function init()
    {

        $this->jsOptions['position'] = View::POS_BEGIN;

        parent::init();

    }

}