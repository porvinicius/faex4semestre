<?php

namespace App\Controllers\adm;

use App\Core\Controller;
use App\Utils\View;

class AdmController extends Controller
{
  protected function render($way, $vars = [])
  {

    $content = View::render($way, array_merge($vars, $this->dataDefaultTemplate));

    echo $content;
  }
}