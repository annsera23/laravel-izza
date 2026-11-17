<?php

namespace App\Http\Controllers\Api\Public;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get products
        $products = Product::with('category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->when(request()->q, function($products) {
                $products = $products->where('title', 'like', '%'. request()->q . '%');
            })
            ->latest()
            ->paginate(8);

        //calculate avg rating for each product
        $products->getCollection()->transform(function ($product) {
            $product->ratings_avg_rating = number_format((float)$product->ratings_avg_rating, 1, '.', '');
            return $product;
        });

        //return response JSON products
        return response()->json([
            'success' => true,
            'message' => 'List Data Products',
            'data'    => $products
        ]);
    }

    /**
     * show
     *
     * @param mixed $slug
     * @return void
     */
    public function show($slug)
    {
        //get product
        $product = Product::with(['category', 'ratings.customer'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->where('slug', $slug)
            ->first();

        if ($product) {
            //format avg rating
            $product->ratings_avg_rating = number_format((float)$product->ratings_avg_rating, 1, '.', '');

            //return response JSON product
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Product',
                'data'    => $product
            ]);
        }

        //return response JSON product not found
        return response()->json([
            'success' => false,
            'message' => 'Data Product Tidak Ditemukan',
            'data'    => null
        ], 404);
    }

    /**
     * productsPopular
     *
     * @return void
     */
    public function productsPopular()
    {
        //get products popular
        $products = Product::with('category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderBy('ratings_count', 'desc')
            ->take(6)
            ->get();

        //format avg rating
        $products->transform(function ($product) {
            $product->ratings_avg_rating = number_format((float)$product->ratings_avg_rating, 1, '.', '');
            return $product;
        });

        //return response JSON products popular
        return response()->json([
            'success' => true,
            'message' => 'List Data Products Populer',
            'data'    => $products
        ]);
    }
}