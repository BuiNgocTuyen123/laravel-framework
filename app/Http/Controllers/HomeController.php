<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_cateory_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product);
    }
}
