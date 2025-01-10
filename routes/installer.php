<?php

use App\Http\Controllers\installer\InstallerController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['XssSanitization']], function () {

    Route::get('install', [InstallerController::class, 'installContent'])->name('install');
    Route::get('install/requirements', [InstallerController::class, 'requirement'])->name('install.requirement');
    Route::get('install/permission', [InstallerController::class, 'permission'])->name('install.permission');
    Route::post('install/environment', [InstallerController::class, 'environment'])->name('install.environment');
    Route::post('install/database', [InstallerController::class, 'database'])->name('install.database');
    Route::get('install/import-demo', [InstallerController::class, 'importDemo'])->name('install.import-demo');
    Route::get('install/demo', [InstallerController::class, 'imported'])->name('install.demo');
    Route::get('install/final', [InstallerController::class, 'finish'])->name('install.final');
    Route::post('install/purchase-code', [InstallerController::class, 'purchaseCode'])->name('purchase.code');

});
