<?php

namespace App\Controllers\pages;

class ErrorController
{
    public function index($errorCode)
    {
        echo $errorCode;
    }
}