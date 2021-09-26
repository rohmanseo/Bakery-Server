<?php

namespace App\Http\Controllers;

use App\Models\Bread;
use Illuminate\Http\Request;

class BreadController extends BaseController
{
    function getBreads(Request $request){
        $breads = Bread::all();
        return $this->responseWithCollection($breads);
    }

    function getPopular(Request $request){
        $breads = Bread::take(4)->orderByDesc('views')->get();
        return$this->responseWithCollection($breads);
    }
}
