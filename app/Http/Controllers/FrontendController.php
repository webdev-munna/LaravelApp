<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\Thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\CssSelector\Node\FunctionNode;

class FrontendController extends Controller
{
    public function home()
    {
        $categories = Category::all(); //take(6)->get();
        $products = Product::orderBy('created_at', 'DESC')->get();

        $recentProducts = Product::orderBy('created_at', 'DESC')->get();

        $topRatedProducts = OrderedProduct::whereNotNull('review')->groupBy('productId')
            ->selectRaw('sum(star) as sum, productId')->orderBy('sum', "DESC")
            ->get('sum', 'productId');

        $topSellerProducts = OrderedProduct::groupBy('productId')
            ->selectRaw('sum(quantity) as sum, productId')->orderBy('sum', "DESC")
            ->get('sum', 'productId');

        return view('frontend.index', [
            'categories' => $categories,
            'products' => $products,
            'topSellerProducts' => $topSellerProducts,
            'recentProducts' => $recentProducts,
            'topRatedProducts' => $topRatedProducts,
        ]);
    }
    public function categorywiseProduct($categoryId)
    {
        // getting all products of a category
        $searchProduct = product::where('categoryId', $categoryId)->orderBy("id", "DESC")->get();
        // $searchProduct = Product::where(function ($q) use ($categoryId) {
        //     if (!empty($categoryId) && $categoryId != '' && $categoryId != 'undefined') {
        //         $q->where(function ($q) use ($categoryId) {
        //             $q->where('categoryId', $categoryId);
        //         });
        //     }
        // })->orderBy("id", "DESC")->get();
        $categories = Category::all(); //take(6)->get();
        return view('frontend.categorywiseProduct', [
            'categories' => $categories,
            'products' => $searchProduct
        ]);
    }
    public function productDetails($slug)
    {
        $productInfo = Product::where('slug', $slug)->get();
        $thumbnail = Thumbnail::where('productId', $productInfo->first()->id)->get();
        $matchingProduct = Product::where('categoryId', $productInfo->first()->categoryId)->where('id', '!=', $productInfo->first()->id)->get();
        $availableColor = Inventory::where('productId', $productInfo->first()->id)->groupBy('colorId')
            ->selectRaw('colorId')
            ->get('colorId');
        $availableSize = Inventory::where('productId', $productInfo->first()->id)->groupBy('sizeId')
            ->selectRaw('sum(sizeId) as sum, sizeId')
            ->get('sum', 'sizeId');
        // review product
        $productReview = OrderedProduct::where('productId', $productInfo->first()->id)->whereNotNull('review')->get();
        $totalReview = OrderedProduct::where('productId', $productInfo->first()->id)->whereNotNull('review')->count();
        $totalStar = OrderedProduct::where('productId', $productInfo->first()->id)->whereNotNull('review')->sum('star');
        $avarageReview = ($totalReview > 0) ? round($totalStar / $totalReview) : 0;
        //return $productReview;
        return view('frontend.productDetails', [
            'thumbnail' => $thumbnail,
            'productInfo' => $productInfo,
            'matchingProduct' => $matchingProduct,
            'availableColors' => $availableColor,
            'availableSizes' => $availableSize,
            'productReview' => $productReview,
            'totalReview' => $totalReview,
            'avarageReview' => $avarageReview,
        ]);
    }

    public function productReview(Request $request, $productId)
    {
        OrderedProduct::where('customerId', Auth::guard('customerLogin')->id())->where('productId', $productId)->update([
            'review' => $request->reviewDescription,
            'star' => $request->rating,
        ]);
        return back()->with('tab2_active', true);
    }

    public function getSize(Request $request)
    {
        $str = '';
        $getSize = Inventory::where('productId', $request->productId)->where('colorId', $request->colorId)->get();
        foreach ($getSize as $size) {
            if ($size->sizeId != 1) {
                $str .= '<div class="form-check form-option size-option  form-check-inline mb-2">
                <input class="form-check-input productSize" type="radio" name="sizeId" id="' . $size->sizeId . '" value="' . $size->sizeId . '">
                <label class="form-option-label" for="' . $size->sizeId . '">' . $size->relToSize->productSize . '</label>
                </div>';
            } else {
                $str .= '<div class="form-check form-option size-option  form-check-inline mb-2">
                <input class="form-check-input productSize" value="' . $size->sizeId . '" type="radio" name="sizeId" id="50" checked>
                <label class="form-option-label" for="50">' . $size->relToSize->productSize . '</label>
              </div>';
            }
        }
        echo $str;
    }
    public function getColor(Request $request)
    {
        $str = '';
        $getColors = Inventory::where('productId', $request->productId)->where('sizeId', $request->sizeId)->get();
        foreach ($getColors as $getColor) {
            if ($getColor->colorId != 1) {
                $str .= '<div class="form-check form-option form-check-inline mb-1">
               <input class="form-check-input getSize" type="radio" name="colorId"  id="' . $getColor->colorId . '"
               value="' . $getColor->colorId . '">
               <label class="form-option-label rounded-circle" for="' . $getColor->colorId . '"><span
                   class="form-option-color rounded-circle"
                   style="background:' . $getColor->relToColor->colorName . '"></span></label>
             </div>';
            } else {
                $str .= '<div class="form-check form-option size-option  form-check-inline mb-2">
                <input class="form-check-input getSize"  value="' . $getColor->colorId . '" type="radio" name="colorId" id="50"
                  checked>
                <label class="form-option-label" for="50">' . $getColor->relToColor->colorName . '</label>
              </div>';
            }
        }
        echo $str;
    }
    public function registerLogin()
    {
        return view('frontend.customerRegisterLogin');
    }
}
