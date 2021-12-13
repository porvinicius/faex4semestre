<?php

namespace App\Controllers\pages;

use App\Core\Controller;
use App\Utils\View;

class PagesController extends Controller
{
    protected function render($way, $vars = [])
    {
        $content = View::render($way, array_merge($vars, $this->dataDefaultTemplate));

        echo $content;
    }
}