<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $testimonials = Testimonial::where('is_active', 1)
        ->latest('id')
        ->limit(3)
        ->select(['id', 'client_name', 'client_designation', 'client_message', 'client_image'])
        ->get();


        $categories =Category::where('is_active', 1)
        ->latest('id')
        ->limit(5)
        ->select(['id', 'title', 'slug','category_image'])
        ->get();
        $products = Product::where('is_active',1)
            ->latest('id')
            ->select('id','name','slug','product_price', 'product_stock', 'product_rating', 'product_image')
            ->paginate(12);
        //return $categories;
         //return $testimonials;
        return view('frontend.pages.home', compact(
            'testimonials',
            'categories',
            'products'
        ));
    }
    public function shopPage()
    {
        $allproducts = Product::where('is_active', 1)
        ->latest('id')
        ->select('id','name','slug','product_price', 'product_stock', 'product_rating', 'product_image')
        ->paginate(12);
        //  $allproducts;
        $categories = Category::where('is_active', 1)
        ->with('products')
        ->latest('id')
        ->limit(5)
        ->select('id', 'title', 'slug')
        ->get();

        return view('frontend.pages.shop',compact('allproducts','categories'));
    }
}
