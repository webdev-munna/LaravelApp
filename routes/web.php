<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginrController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FilterProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\WishlistController;
use App\Models\ProductColor;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

// backend / admin section

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// users
Route::get('/admin', [UserController::class, 'admin'])->middleware('adminLogin');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/user-list', [UserController::class, 'userList'])->name('userList')->middleware('permission:user.list');
Route::get('/user-delete/{userDelete}', [UserController::class, 'userDelete'])->name('userDelete')->middleware('permission:user.delete');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password', [UserController::class, 'updatePass'])->name('updatePass');
Route::post('/update-image', [UserController::class, 'updateImg'])->name('updateImg');

//category
Route::get('/category', [CategoryController::class, 'category'])->name('category')->middleware('permission:category.create');
Route::post('/category/store', [CategoryController::class, 'categoryStore'])->name('categoryStore');
Route::get('/category/delete/{categoryDeleteId}', [CategoryController::class, 'categoryDelete'])->name('categoryDelete')->middleware('permission:category.delete');
Route::get('/category/restore/{categoryRestoreId}', [CategoryController::class, 'categoryRestore'])->name('categoryRestore');
Route::get('/category/force-delete/{categoryId}', [CategoryController::class, 'categoryForceDelete'])->name('categoryForceDelete');
Route::get('/category/edit/{editCatId}', [CategoryController::class, 'categoryEdit'])->name('categoryEdit')->middleware('permission:category.edit');
Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('updateCategory');

// subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subCategory'])->name('subCategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategoryStore'])->name('subcategoryStore');
Route::get('/subcategory/delete/{subcategoryId}', [SubcategoryController::class, 'deleteSubcategory'])->name('deleteSubcategory');
Route::get('/subcategory/edit/{subcategoryId}', [SubcategoryController::class, 'editSubcategory'])->name('editSubcategory');
Route::get('/subcategory/force-delete/{subcategoryId}', [SubcategoryController::class, 'permantdeleteSubcategory'])->name('permantdeleteSubcategory');
Route::get('/subcategory/restore/{subcategoryId}', [SubcategoryController::class, 'restoreSubcategory'])->name('restoreSubcategory');
Route::post('/subcategory/update', [SubcategoryController::class, 'updateSubcategory'])->name('updateSubcategory');

// product
Route::get('/add-product', [ProductController::class, 'addProduct'])->name('addProduct');
Route::get('/product/product-variation', [ProductController::class, 'productVariation'])->name('productVariation');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'productStore'])->name('productStore');
Route::get('/product/view', [ProductController::class, 'viewProduct'])->name('viewProduct');
Route::get('/product/soft-delete/{productId}', [ProductController::class, 'softDelete'])->name('softDelete');
Route::get('/product/delete/{productId}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
Route::post('/product/color-store', [ProductController::class, 'colorStore'])->name('colorStore');
Route::post('/product/size-store', [ProductController::class, 'productSize'])->name('productSize');
Route::get('/product/delete-color/{colorId}', [ProductController::class, 'deleteColor'])->name('deleteColor');
Route::get('/product/delete-size/{sizeId}', [ProductController::class, 'deleteSize'])->name('deleteSize');
Route::get('/product/inventory/{productId}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/product/inventory', [ProductController::class, 'inventoryStore'])->name('inventoryStore');
Route::get('/product/inventory/delete/{inventoryId}', [ProductController::class, 'inventoryDelete'])->name('inventoryDelete');
Route::get('/product/inventory/edit/{inventoryId}', [ProductController::class, 'editInventory'])->name('editInventory');
Route::post('/product/inventory/update', [ProductController::class, 'updateInventory'])->name('updateInventory');

// frontend section
Route::get('/', [FrontendController::class, 'home'])->name('frontHome');
Route::get('/category/product/{categorywiseProduct}', [FrontendController::class, 'categorywiseProduct'])->name('categorywise.product');
Route::get('/product/details/{slug}', [FrontendController::class, 'productDetails'])->name('productDetails'); //->middleware('customerLogin');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::post('/getColor', [FrontendController::class, 'getColor']);

// Customer
Route::get('/customer/profile', [CustomerController::class, 'customerProfile'])->name('customerProfile');
Route::post('/customer/profile/update', [CustomerController::class, 'updateCustomerProfile'])->name('updateCustomerProfile');
Route::get('/customer/my-order', [CustomerController::class, 'myOrder'])->name('myOrder');

// customer login/register
Route::get('/register-login', [FrontendController::class, 'registerLogin'])->name('registerLogin');
Route::post('/customer/store', [CustomerRegisterController::class, 'customerRegister'])->name('customerRegister');
Route::post('/customer/login', [CustomerLoginrController::class, 'loginCustomer'])->name('customerLogin');
Route::get('/customer/logout', [CustomerLoginrController::class, 'customerLogout'])->name('customerLogout');

//Google
Route::get('/login/google', [CustomerLoginrController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [CustomerLoginrController::class, 'handleGoogleCallback']);

//Facebook
// Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
// Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

//Github
Route::get('/login/github', [CustomerLoginrController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [CustomerLoginrController::class, 'handleGithubCallback']);

//cart
Route::post('/cart/store', [CartController::class, 'cartStore'])->name('cartStore');
Route::get('/cart/delete/{cartId}', [CartController::class, 'deleteCart'])->name('deleteCart');
Route::get('/cart/view-cart', [CartController::class, 'viewCart'])->name('viewCart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('updateCart');

//wishlist
//Route::post('/wishlist', [WishlistController::class, 'wishList'])->name('wishList');
Route::get('/wishlist/delete/{wishlistId}', [CartController::class, 'wishlistDelete'])->name('wishlistDelete');

// coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'couponStore'])->name('couponStore');
Route::get('/coupon/edit/{couponId}', [CouponController::class, 'couponEdit'])->name('couponEdit');
Route::get('/coupon/delete/{couponId}', [CouponController::class, 'couponDelete'])->name('couponDelete');
Route::post('/coupon/update', [CouponController::class, 'couponUpdate'])->name('couponUpdate');

// order checkout
Route::get('/cart/checkout', [CheckoutController::class, 'checkOut'])->name('checkOut');
Route::post('/getCity', [CheckoutController::class, 'getCity']);

// order
Route::post('/order/store', [CheckoutController::class, 'orderStore'])->name('orderStore');
Route::get('/order/complete', [CheckoutController::class, 'orderSuccess'])->name('orderSuccess');
Route::get('/order/invoice/download/{orderId}', [CustomerController::class, 'orderInvoiceDownload'])->name('order.invoice.download');

// backend
Route::get('/customer/order', [CustomerOrderController::class, 'customerOrder'])->name('customerOrder');
Route::post('/customer/order/status', [CustomerOrderController::class, 'customerOrderStatus'])->name('customerOrderStatus');
Route::get('/customer/wishlist', [CustomerOrderController::class, 'customerWishlist'])->name('customerWishlist');
Route::get('/customer/wishlist/delete/{wishlistId}', [CustomerOrderController::class, 'delWishlist'])->name('delWishlist');

// SSLCOMMERZ Start

// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// STRIPE
Route::controller(StripePaymentController::class)->group(function () {
  Route::get('stripe', 'stripe');
  Route::post('stripe', 'stripePost')->name('stripe.post');
});
// STRIPTE END

// Review 
Route::post('/review/{productId}', [FrontendController::class, 'productReview'])->name('productReview');

// Customer password reset
Route::get('/password-reset/email', [CustomerController::class, 'passResetEmail'])->name('pass.reset.email');
Route::post('/password-reset/store', [CustomerController::class, 'passResetStore'])->name('customer.pass.reset.store');
Route::get('/password-reset/confirm/{token}', [CustomerController::class, 'passResetConfirm'])->name('customer.pass.reset.confirm');
Route::post('/password-reset/confirm/store/{token}', [CustomerController::class, 'passResetConfirmStore'])->name('customer.pass.reset.confirm.store');

// Customer email verify
Route::get('/customer/email-verify/{token}', [CustomerRegisterController::class, 'confirmEmail'])->name('confirm.email.verify');

// Filter Product (shop)
Route::get('/filter-product', [FilterProductController::class, 'filterProduct'])->name('filter.product');

// Role Permission Route
Route::get('/create/permission', [RolePermissionController::class, 'CreatePermission'])->name('create.permission');
Route::post('/permission/store', [RolePermissionController::class, 'PermissionStore'])->name('permission.store');
Route::get('/permission/edit/{permisssionId}', [RolePermissionController::class, 'PermissionEdit'])->name('permission.edit');
Route::post('/permission/update/{permissionId}', [RolePermissionController::class, 'PermissionUpdate'])->name('permission.update');
Route::get('/permission/delete/{permissionId}', [RolePermissionController::class, 'PermissionDelete'])->name('permission.delete');
Route::get('/create/assign/role', [RolePermissionController::class, 'createAssignRole'])->name('create.assign.role');
Route::post('/create/assign/store', [RolePermissionController::class, 'AssignRoleStore'])->name('role.assign.store');
Route::get('/role/assign/edit/{roleId}', [RolePermissionController::class, 'AssignRolePermissionEdit'])->name('role.permission.edit');
Route::post('/role/assign/update/{roleId}', [RolePermissionController::class, 'AssignRolePermissionUpdate'])->name('role.permission.update');
Route::get('/role/assign/delete/{roleId}', [RolePermissionController::class, 'AssignRolePermissionDelete'])->name('role.permission.delete');
Route::get('/role/assign/user', [RolePermissionController::class, 'createUserRole'])->name('create.user.role');
Route::post('/assign/user/role/store', [RolePermissionController::class, 'assignUserRoleStore'])->name('assign.user.role.store');
Route::get('/assign/user/role/edit/{userId}', [RolePermissionController::class, 'assignUserRoleEdit'])->name('assign.user.role.edit');
Route::post('/assign/user/role/update/', [RolePermissionController::class, 'assignUserRoleUpdate'])->name('assign.user.role.update');
// End Role Permission Route
