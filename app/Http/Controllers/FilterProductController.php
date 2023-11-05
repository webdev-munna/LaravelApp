<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class FilterProductController extends Controller
{
    public function filterProduct(Request $request)
    {
        $searchData = $request->all();
        $sorting = "created_at";
        $type = "DESC";
        if (!empty($searchData['sortBy']) && $searchData['sortBy'] != '' && $searchData['sortBy'] != 'undefined') {
            if ($searchData['sortBy'] == 1) {
                $sorting = "afterDiscount";
                $type = "ASC";
            } elseif ($searchData['sortBy'] == 2) {
                $sorting = "afterDiscount";
                $type = "DESC";
            } elseif ($searchData['sortBy'] == 3) {
                $sorting = "productName";
                $type = "ASC";
            } elseif ($searchData['sortBy'] == 4) {
                $sorting = "productName";
                $type = "DESC";
            } else {
                $sorting = "created_at";
                $type = "DESC";
            }
        }
        $searchProduct = Product::where(function ($q) use ($searchData) {

            $min = 0;
            if (!empty($searchData['min']) && $searchData['min'] != '' && $searchData['min'] != 'undefined') {
                $min = $searchData['min'];
            } else {
                $min = 1;
            }

            if (!empty($searchData['qry']) && $searchData['qry'] != '' && $searchData['qry'] != 'undefined') {
                $q->where(function ($q) use ($searchData) {
                    $q->where('productName', 'like', '%' . $searchData['qry'] . '%');
                    $q->orWhere('longDescription', 'like', '%' . $searchData['qry'] . '%');
                    $q->orWhere('shortDescription', 'like', '%' . $searchData['qry'] . '%');
                });
            }

            if (!empty($searchData['min']) && $searchData['min'] != '' && $searchData['min'] != 'undefined' || !empty($searchData['max']) && $searchData['max'] != '' && $searchData['max'] != 'undefined') {
                $q->whereBetween('afterDiscount', [$min, $searchData['max']]);
            }

            if (!empty($searchData['category']) && $searchData['category'] != '' && $searchData['category'] != 'undefined') {
                $q->where(function ($q) use ($searchData) {
                    $q->where('categoryId', 'like', '%' . $searchData['category'] . '%');
                });
            }

            if (!empty($searchData['color']) && $searchData['color'] != '' && $searchData['color'] != 'undefined' || !empty($searchData['size']) && $searchData['size'] != '' && $searchData['size'] != 'undefined') {
                // go to Product to Inventory Model.
                $q->whereHas('relToInventory', function ($q) use ($searchData) {
                    // match color
                    if (!empty($searchData['color']) && $searchData['color'] != '' && $searchData['color'] != 'undefined') {
                        // go to Inventory to ProductColor Model.
                        $q->whereHas('relToColor', function ($q) use ($searchData) {
                            $q->where('product_colors.id', $searchData['color']);
                        });
                    }
                    //  match size
                    if (!empty($searchData['size']) && $searchData['size'] != '' && $searchData['size'] != 'undefined') {
                        // go to Inventory to ProductSize Model.
                        $q->whereHas('relToSize', function ($q) use ($searchData) {
                            $q->where('product_sizes.id', $searchData['size']);
                        });
                    }
                });
            }
        })->orderBy($sorting, $type)->get();

        $categories = Category::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        return view('frontend.filterProduct', compact('searchProduct', 'categories', 'colors', 'sizes'));
    }
}
