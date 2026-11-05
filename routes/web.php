<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentAdminController;
use App\Http\Controllers\DataHubController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\ResourceAdminController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::prefix('learning')->name('learning.')->group(function (): void {
    Route::get('/', [LearningController::class, 'index'])->name('index');
    Route::get('/resources', [LearningController::class, 'resources'])->name('resources');
    Route::get('/blog/{slug}', [LearningController::class, 'articleShow'])->name('blog.show');
    Route::get('/guides/{slug}', [LearningController::class, 'guideShow'])->name('guides.show');
    // Former index pages now live on the combined Resources page.
    Route::redirect('/blog', '/learning/resources?type=article', 301)->name('blog.index');
    Route::redirect('/guides', '/learning/resources?type=guide', 301)->name('guides.index');
    Route::redirect('/library', '/learning/resources?type=download', 301)->name('library');
    Route::get('/faqs', [LearningController::class, 'faqs'])->name('faqs');
});

Route::get('/success-stories', [TestimonialController::class, 'index'])->name('success-stories');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');

Route::prefix('forms')->name('forms.')->group(function (): void {
    Route::get('/', [PageController::class, 'formsHub'])->name('hub');
    Route::get('/purchase', [PublicFormController::class, 'purchaseForm'])->name('purchase');
    Route::post('/purchase', [PublicFormController::class, 'purchaseStore'])->middleware('throttle:20,1')->name('purchase.store');
    Route::get('/sales', [PublicFormController::class, 'salesForm'])->name('sales');
    Route::post('/sales', [PublicFormController::class, 'salesStore'])->middleware('throttle:20,1')->name('sales.store');
    Route::get('/dmms', [PublicFormController::class, 'dmmsForm'])->name('dmms');
    Route::post('/dmms', [PublicFormController::class, 'dmmsStore'])->middleware('throttle:20,1')->name('dmms.store');
    Route::get('/incubation', [PublicFormController::class, 'incubationForm'])->name('incubation');
    Route::post('/incubation', [PublicFormController::class, 'incubationStore'])->middleware('throttle:20,1')->name('incubation.store');
});

Route::prefix('store')->name('store.')->group(function (): void {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{productId}', [CartController::class, 'update'])
        ->whereNumber('productId')
        ->name('cart.update');
    Route::delete('/cart/{productId}', [CartController::class, 'remove'])
        ->whereNumber('productId')
        ->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/{order}/confirmation', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/', [StoreController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [StoreController::class, 'show'])->name('show');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/data-hub', [DataHubController::class, 'overview'])->name('data-hub.index');
    Route::get('/data-hub/module/{module}', [DataHubController::class, 'module'])
        ->name('data-hub.module')
        ->where('module', 'purchases|sales|dmms|incubation|contacts');
    Route::get('/data-hub/module/{module}/export', [DataHubController::class, 'export'])
        ->name('data-hub.module.export')
        ->where('module', 'purchases|sales|dmms|incubation|contacts');
    Route::get('/data-hub/contacts/create', [DataHubController::class, 'createContact'])->name('data-hub.contacts.create');
    Route::post('/data-hub/contacts', [DataHubController::class, 'storeContact'])->name('data-hub.contacts.store');

    Route::get('/data-hub/orders', [OrderAdminController::class, 'index'])->name('data-hub.orders.index');
    Route::get('/data-hub/orders/{order}', [OrderAdminController::class, 'show'])->name('data-hub.orders.show');
    Route::patch('/data-hub/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('data-hub.orders.status');

    Route::get('/data-hub/products', [ProductManageController::class, 'index'])->name('data-hub.products.index');
    Route::get('/data-hub/products/create', [ProductManageController::class, 'create'])->name('data-hub.products.create');
    Route::post('/data-hub/products', [ProductManageController::class, 'store'])->name('data-hub.products.store');
    Route::get('/data-hub/products/{productId}/edit', [ProductManageController::class, 'edit'])
        ->whereNumber('productId')
        ->name('data-hub.products.edit');
    Route::put('/data-hub/products/{productId}', [ProductManageController::class, 'update'])
        ->whereNumber('productId')
        ->name('data-hub.products.update');
    Route::delete('/data-hub/products/{productId}', [ProductManageController::class, 'destroy'])
        ->whereNumber('productId')
        ->name('data-hub.products.destroy');

    Route::prefix('/data-hub/resources')->name('data-hub.resources.')->group(function (): void {
        Route::get('/', [ResourceAdminController::class, 'index'])->name('index');
        Route::get('/create', [ResourceAdminController::class, 'create'])->name('create');
        Route::post('/', [ResourceAdminController::class, 'store'])->name('store');
        Route::get('/{resource:id}/edit', [ResourceAdminController::class, 'edit'])->whereNumber('resource')->name('edit');
        Route::put('/{resource:id}', [ResourceAdminController::class, 'update'])->whereNumber('resource')->name('update');
        Route::delete('/{resource:id}', [ResourceAdminController::class, 'destroy'])->whereNumber('resource')->name('destroy');
    });

    Route::prefix('/data-hub/faqs')->name('data-hub.content.')->group(function (): void {
        Route::get('/', [ContentAdminController::class, 'index'])->name('index');
        Route::get('/create', [ContentAdminController::class, 'create'])->name('create');
        Route::post('/', [ContentAdminController::class, 'store'])->name('store');
        Route::get('/{faq}/edit', [ContentAdminController::class, 'edit'])->whereNumber('faq')->name('edit');
        Route::put('/{faq}', [ContentAdminController::class, 'update'])->whereNumber('faq')->name('update');
        Route::delete('/{faq}', [ContentAdminController::class, 'destroy'])->whereNumber('faq')->name('destroy');
    });

    Route::middleware('can:manage-users')->prefix('/data-hub/users')->name('data-hub.users.')->group(function (): void {
        Route::get('/', [UserAdminController::class, 'index'])->name('index');
        Route::get('/create', [UserAdminController::class, 'create'])->name('create');
        Route::post('/', [UserAdminController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserAdminController::class, 'edit'])->whereNumber('user')->name('edit');
        Route::put('/{user}', [UserAdminController::class, 'update'])->whereNumber('user')->name('update');
        Route::delete('/{user}', [UserAdminController::class, 'destroy'])->whereNumber('user')->name('destroy');
    });
});
