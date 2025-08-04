<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NameAddressController;
use App\Http\Controllers\ChildController;

// أهالي (NameAddress)
Route::apiResource('name-addresses', NameAddressController::class);

// أطفال (Child)
Route::apiResource('children', ChildController::class);

// راوت إضافي: جلب أطفال أب/أم معينين
Route::get('parents/{id}/children', [NameAddressController::class, 'children']);

Route::get('name-addresses', [NameAddressController::class, 'index']);
Route::get('/export-excel', [NameAddressController::class, 'exportExcel']);

Route::get('export-pdf', [NameAddressController::class, 'exportPDF']);
