<?php

namespace App\Http\Controllers;


use League\CommonMark\Inline\Element\Strong;

class DataController extends Controller
{

    public function __invoke()
    {
        return config('images');
    }
    //
}
