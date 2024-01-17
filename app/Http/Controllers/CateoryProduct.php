<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class CateoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }
        else{
           return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->AuthLogin();
        return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->AuthLogin();
        $all_category_product = DB::table('tbl_cateory_product')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    
    public function save_category_product(Request $request){
        $data = array(); // Khai báo một mảng để lưu dữ liệu
        $this->AuthLogin();
        // Gán dữ liệu từ request vào mảng $data
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        DB::table('tbl_cateory_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-category-product');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_cateory_product')->where('category_id', $category_product_id)->update(['category_status' => 1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');

    }   
        public function active_category_product($category_product_id){
            $this->AuthLogin();
            DB::table('tbl_cateory_product')->where('category_id', $category_product_id)->update(['category_status' => 0]);
            Session::put('message',' kích hoạt danh mục sản phẩm thành công');
            return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_products = DB::table('tbl_cateory_product')->where('category_id',$category_product_id)->get();
        $manager_category_products = view('admin.edit_category_product')->with('edit_category_products',$edit_category_products);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_products);
    }
    public function update_category_product(Request $request, $category_product_id){
        $data = array(); // Khai báo một mảng để lưu dữ liệu
        $this->AuthLogin();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_cateory_product')->where('category_id', $category_product_id)->update($data);
        Session::put('message','cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_cateory_product')->where('category_id', $category_product_id)->delete();
        Session::put('message','xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
}
