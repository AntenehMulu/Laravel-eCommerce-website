<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\ForgetPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use Filament\Support\Exceptions\Cancel;

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

Route::get('/',HomePage::class);
Route::get('/categories',CategoriesPage::class);
Route::get('/products',ProductsPage::class);
Route::get('/cart',CartPage::class);
Route::get('/products/{slug}',ProductDetailPage::class);
Route::get('checkout', CheckoutPage::class);
Route::get('/my-orders',MyOrdersPage::class);
Route::get('/my-orders/{order}',MyOrderDetailPage::class);
Route::get('/login',LoginPage::class);
Route::get('/register',RegisterPage::class);
Route::get('/forgot', ForgetPage::class);
Route::get('/reset',ResetPasswordPage::class);
Route::get('/success',SuccessPage::class);
Route::get('/cancel',CancelPage::class);
