<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Image;

class CategoryController extends Controller
{
    public function category()
    {
        $categoryInfo = Category::all();
        $trashCategory = Category::onlyTrashed()->get();
        return view('admin.category.category', [
            'categories' => $categoryInfo,
            'trashCategories' => $trashCategory,
        ]);
    }
    public function categoryStore(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            //'category_image' => 'required',
        ]);
        $categoryId = Category::insertGetId([
            'category_name' => $request->category_name,
            'added_by' => auth::id(),
        ]);
        $request->validate([
            'category_image' => 'required',
        ]);
        $uploadedImg = $request->category_image;
        $extension = $uploadedImg->getClientOriginalExtension();
        //$fileName = $categoryId . '.' . $extension;
        $fileName = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . rand(100000, 999999) . '.' . $extension;
        Image::make($uploadedImg)->resize(300, 200)->save(public_path('uploads/category/' . $fileName));
        Category::find($categoryId)->update([
            'category_image' => $fileName,
        ]);
        return back()->with('categoryIns', 'Category inserted successfully.');
    }
    public function categoryDelete($categoryDeleteId)
    {
        Category::find($categoryDeleteId)->delete();
        return back()->with('delCategory', 'Category moved to trash.');
    }
    public function categoryRestore($categoryRestoreId)
    {
        Category::onlyTrashed()->find($categoryRestoreId)->restore();
        return back()->with('categoryRestore', 'Category restored successfully.');
    }
    public function categoryForceDelete($categoryId)
    {
        $categoryImg = Category::onlyTrashed()->find($categoryId);
        $deleteFrom = public_path('uploads/category/' . $categoryImg->category_image);
        unlink($deleteFrom);
        //Category::onlyTrashed()->where('id', $categoryId)->forceDelete();
        Category::onlyTrashed()->find($categoryId)->forceDelete();
        return back()->with('categoryFDelete', 'Permanently deleted this category.');
    }
    public function categoryEdit($editCatId)
    {
        $categoryInfo = Category::find($editCatId);
        return view('admin.category.editCategory', [
            'category' => $categoryInfo
        ]);
    }
    public function updateCategory(Request $request)
    {
        if (Category::where('id', $request->category_id)->where('category_name', $request->category_name)->exists()) {
            if ($request->category_image == '') {
                Category::find($request->category_id)->update([
                    'category_name' => $request->category_name,
                    'added_by' => auth::id(),
                ]);
                return back()->with('categoryUpdate', 'Category udpated successfully.');
            } else {
                $delImg = Category::find($request->category_id);
                $deleteFrom = public_path('uploads/category/' . $delImg->category_image);
                $delFile = unlink($deleteFrom);
                if ($delFile) {
                    $request->validate([
                        'category_image' => 'required|mimes:png,jpg,jfif,gif,webp|max:2024'
                    ]);
                    $uploadedImg = $request->category_image;
                    $extension = $uploadedImg->getClientOriginalExtension();
                    $fileName = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . rand(100000, 999999) . '.' . $extension;
                    Image::make($uploadedImg)->save(public_path('uploads/category/' . $fileName));
                    Category::find($request->category_id)->update([
                        'category_name' => $request->category_name,
                        'category_image' => $fileName,
                        'added_by' => auth::id()
                    ]);
                    return back()->with('categoryUpdate', 'Category udpated successfully.');
                }
            }
        } else {
            if (Category::where('category_name', $request->category_name)->exists()) {
                return back()->with('categoryExists', 'The category already exists.');
            } else {
                if ($request->category_image == '') {
                    Category::find($request->category_id)->update([
                        'category_name' => $request->category_name,
                        'added_by' => auth::id(),
                    ]);
                    return back();
                } else {
                    $delImg = Category::find($request->category_id);
                    $deleteFrom = public_path('uploads/category/' . $delImg->category_image);
                    $delFile = unlink($deleteFrom);
                    if ($delFile) {
                        $request->validate([
                            'category_image' => 'required|mimes:png,jpg,jfif,gif,webp|max:2024'
                        ]);
                        $uploadedImg = $request->category_image;
                        $extension = $uploadedImg->getClientOriginalExtension();
                        $fileName = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . rand(100000, 999999) . '.' . $extension;
                        Image::make($uploadedImg)->save(public_path('uploads/category/' . $fileName));
                        Category::find($request->category_id)->update([
                            'category_name' => $request->category_name,
                            'category_image' => $fileName,
                            'added_by' => auth::id()
                        ]);
                        return back()->with('categoryUpdate', 'Category udpated successfully.');
                    }
                }
            }
        }
    }
}
