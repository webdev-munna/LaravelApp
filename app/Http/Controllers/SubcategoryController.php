<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function subCategory()
    {
        $category = Category::all();
        $subCategory = Subcategory::all();
        $trashSubCategory = Subcategory::onlyTrashed()->get();
        return view('admin.subCategory.subCategory', [
            'categories' => $category,
            'subCategories' => $subCategory,
            'trashsubCategory' => $trashSubCategory
        ]);
    }
    public function subcategoryStore(Request $request)
    {
        $request->validate([
            'categoryId' => 'required',
            'subcategoryName' => 'required'
        ]);
        Subcategory::insert([
            'categoryId' => $request->categoryId,
            'subcategoryName' => $request->subcategoryName,
            'created_at' => Carbon::now()
        ]);
        return back()->with('subcatStore', 'Subcategory inserted successfully.');
    }
    public function deleteSubcategory($subcategoryId)
    {
        Subcategory::find($subcategoryId)->delete();
        return back()->with('delSubcategory', 'Subcategory moved to Trash.');
    }
    public function editSubcategory($subcategoryId)
    {
        $category = Category::all();
        $subCategory = Subcategory::find($subcategoryId);
        return view('admin.subCategory.editSubcategory', [
            'categories' => $category,
            'subCategories' => $subCategory
        ]);
    }
    public function permantdeleteSubcategory($subcategoryId)
    {
        Subcategory::onlyTrashed()->find($subcategoryId)->forceDelete();
        return back()->with('permanantdelSubcategory', 'Permanantly Subcategory deleted successfully.');
    }
    public function restoreSubcategory($subcategoryId)
    {
        Subcategory::onlyTrashed()->find($subcategoryId)->restore();
        return back()->with('restoreSubcategory', 'Subcategory restored successfully.');
    }
    public function updateSubcategory(Request $request)
    {
        Subcategory::find($request->subcategoryId)->update([
            'categoryId' => $request->categoryId,
            'subcategoryName' => $request->subcategoryName
        ]);
        return back()->with('updateSubcategory', 'Subcategory updated successfully.');
    }
}
