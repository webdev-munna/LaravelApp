<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Subcategory;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    public function addProduct()
    {
        $category = Category::all();
        return view('admin.product.addProduct', [
            'categories' => $category
        ]);
    }

    public function getSubcategory(Request $request)
    {
        $str = "<option disabled selected>--Select Subcategory--</option>";
        $subCategories = Subcategory::where('categoryId', $request->categoryId)->get();
        foreach ($subCategories as $subCategory) {
            $str .= "<option value='$subCategory->id'>$subCategory->subcategoryName</option>";
        }
        echo $str;
    }
    public function productStore(Request $request)
    {
        $request->validate([
            'categoryId' => 'required',
            'subcategoryId' => 'required',
            'productName' => 'required',
            'price' => 'required',
            //'preview' => 'required|mimes:png,jpeg,jpg,jfif,gif,webp|max:2024',
            //'thumbnail' => 'required|mimes:png,jpg,jpeg,jfif,gif,webp|max:2024',
        ], [
            'categoryId.required' => 'Please select a category.',
            'subcategoryId.required' => 'Please select a subcategory.',
        ]);
        $productId = Product::insertGetId([
            'categoryId' => $request->categoryId,
            'subcategoryId' => $request->subcategoryId,
            'productName' => $request->productName,
            'slug' => Str::lower(str_replace(' ', '-', $request->productName)) . '-' . rand(100000, 999999),
            'price' => $request->price,
            'discount' => $request->discount,
            'afterDiscount' => $request->price - $request->price * $request->discount / 100,
            'brand' => $request->brandName,
            'shortDescription' => $request->shortDescription,
            'longDescription' => $request->longDescription,
            'created_at' => Carbon::now()
        ]);
        $uploadedImage = $request->preview;
        $extension = $uploadedImage->getClientOriginalExtension();
        $fileName = Str::lower(str_replace(' ', '-', $request->productName)) . '-' . rand(100000, 999999) . '.' . $extension;
        Image::make($uploadedImage)->resize(300, 200)->save(public_path('uploads/product/preview/' . $fileName));
        Product::find($productId)->update([
            'previewImage' => $fileName
        ]);
        foreach ($request->thumbnail as $productThumbnail) {
            $extension2 = $productThumbnail->getClientOriginalExtension();
            $fileName2 = Str::lower(str_replace(' ', '-', $request->productName)) . '-' . rand(100000, 999999) . '.' . $extension2;
            $fileLocation = Image::make($productThumbnail)->resize(300, 200)->save(public_path('uploads/product/thumbnail/' . $fileName2));
            if ($fileLocation) {
                Thumbnail::insert([
                    'productId' => $productId,
                    'productThumbnail' => $fileName2,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                echo "Thumbnail not inserted.";
            }
        }
        return back()->with('productInsert', 'Product inserted successfully.');
    }
    public function viewProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        $trashProduct = Product::onlyTrashed()->get();
        return view('admin.product.viewProduct', [
            'products' => $product,
            'trashProducts' => $trashProduct,
        ]);
    }
    public function softDelete($productId)
    {
        Product::find($productId)->delete();
        $thumnailImg = Thumbnail::where('productId', $productId)->get();
        foreach ($thumnailImg as $thumImg) {
            Thumbnail::find($thumImg->id)->delete();
        }

        return back()->with('productDel', 'Product moved to trash');
    }
    public function deleteProduct($productId)
    {
        $productInfo = Product::onlyTrashed()->find($productId);
        // $productInfo = Product::find('id',$productId)->first()->previewImage;
        $deleteFrom = public_path('uploads/product/preview/' . $productInfo->previewImage);
        $unlink = unlink($deleteFrom);
        Product::onlyTrashed()->find($productId)->forceDelete();
        $thumnailImg = Thumbnail::onlyTrashed()->where('productId', $productId)->get();
        foreach ($thumnailImg as $thumImg) {
            $removeThumFrom = public_path('uploads/product/thumbnail/' . $thumImg->productThumbnail);
            unlink($removeThumFrom);
            Thumbnail::onlyTrashed()->find($thumImg->id)->forceDelete();
        }

        return back()->with('productDel', 'Product deleted successfully.');
    }
    public function productVariation()
    {
        $color = ProductColor::all();
        $size = ProductSize::all();
        return view('admin.product.productVariation', [
            'colors' => $color,
            'sizes' => $size,
        ]);
    }
    public function colorStore(Request $request)
    {
        $request->validate([
            'colorName' => 'required',
        ], [
            'colorName.required' => 'Please enter color name.',
        ]);
        ProductColor::insert([
            'colorName' => $request->colorName,
            'colorCode' => $request->colorCode,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('colorInserted', 'Product color inserted successfully.');
    }
    public function productSize(Request $request)
    {
        $request->validate([
            'size' => 'required',
        ]);
        ProductSize::insert([
            'productSize' => $request->size,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('sizeInserted', 'Product size inserted successfully.');
    }
    public function deleteColor($colorId)
    {
        ProductColor::find($colorId)->delete();
        return back()->with('deleteColor', 'Product color deleted successfully.');
    }
    public function deleteSize($sizezId)
    {
        ProductSize::find($sizezId)->delete();
        return back()->with('deleteSize', 'Product size deleted successfully.');
    }
    public function inventory($productId)
    {
        $productInfos = Product::find($productId);
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        $inventory = Inventory::where('productId', $productId)->get();
        return view('admin.product.inventory', [
            'productInfo' => $productInfos,
            'colors' => $colors,
            'size' => $sizes,
            'inventory' => $inventory
        ]);
    }
    public function inventoryStore(Request $request)
    {
        if (Inventory::where('productId', $request->productId)->where('colorId', $request->colorId)->where('sizeId', $request->sizeId)->exists()) {
            Inventory::where('productId', $request->productId)->where('colorId', $request->colorId)->where('sizeId', $request->sizeId)->increment('quantity', $request->quantity);
            return back()->with('inventoryInsert', 'Inventory increased for this product.');
        } else {
            $request->validate([
                'quantity' => 'required'
            ]);
            Inventory::insert([
                'productId' => $request->productId,
                'colorId' => $request->colorId,
                'sizeId' => $request->sizeId,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now()
            ]);
            return back()->with('inventoryInsert', 'Inventory inserted successfully.');
        }
    }
    public function inventoryDelete($inventoryId)
    {
        Inventory::find($inventoryId)->delete();
        return back()->with('inventoryDel', 'Inventory deleted successfully.');
    }
    public function editInventory($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);
        $colors = ProductColor::all();
        $sizes = ProductSize::all();
        return view('admin.product.editInventory', [
            'inventory' => $inventory,
            'colors' => $colors,
            'size' => $sizes,
        ]);
    }
    public function updateInventory(Request $request)
    {
        Inventory::find($request->inventoryId)->update([
            'colorId' => $request->colorId,
            'sizeId' => $request->sizeId,
            'quantity' => $request->quantity,
            'updated_at' => Carbon::now()
        ]);
        return back()->with('updateInventory', 'Inventory udpated successfully.');
    }
}
