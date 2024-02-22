<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::controller(App\Http\Controllers\MahasiswaController::class)->group(function (){
    Route::get('/', 'index')->name("data.mahasiswa.getdata");
    Route::get('/addform', 'addForm')->name("data.mahasiswa.addform");
    Route::get('/updateform/{nim}', 'updateForm')->name("data.mahasiswa.updateform");
    Route::get('/deleteform/{nim}', 'deleteForm')->name("data.mahasiswa.deleteform");
    Route::post('/addform/process', 'addProcess')->name("data.mahasiswa.addform.process");
    Route::post('/updateform/process', 'updateProcess')->name("data.mahasiswa.updateform.process");
    Route::post('/deleteform/process', 'deleteProcess')->name("data.mahasiswa.deleteform.process");
    // Route::post('/Mahasiswa/process', 'Mahasiswa')->name("data.mahasiswa.auth.Mahasiswa");
    // Route::get('/logout/process', 'logout')->name("data.mahasiswa.auth.logout");
    // Route::post('/insert-request/{id_user}/{lamp_to}/{lamp_status}/{status_data}', 'insertRequest')->name("user.auth.Mahasiswa.insert");
});

Route::get('/file/krs/{filename}', function ($filename) {
    $path = storage_path('app/file/krs/' . $filename);
    
    if (file_exists($path)) {
        return response()->file($path);
    } else {
        abort(404);
    }
});