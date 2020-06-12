<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Https\Controller;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {
    //

    public function simpeleTest() {
        return view('test');
    }

    public function testParam($id) {
        return view('testParameter')->with('id', $id);
    }

    public function index() {
        $products = DB::table('products')->get();

        return view('index', ['products' => $products]);
    }

    public function product($id) {
        $product = DB::table('products')->where('id', $id)->first();
        
        return view('product', ['product' => $product]);
    }
}
