<?php

use App\Http\Controllers\MailController;
use App\Http\Livewire\ShowCommunities;
use App\Http\Livewire\ShowCommunity;
use App\Http\Livewire\ShowPublication;
use App\Http\Livewire\ShowPublicationscommunities;
use App\Http\Livewire\ShowPublicationsuser;
use App\Http\Livewire\ShowPublicationswelcome;
use App\Http\Livewire\ShowTags;
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

Route::get('/', ShowPublicationswelcome::class)->name('inicio');
Route::get('publication/{id}', ShowPublication::class)->name('publication.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', ShowPublicationscommunities::class)->name('dashboard');
    Route::get('communities', ShowCommunities::class)->name('communities.show');
    Route::get('community/{id}', ShowCommunity::class)->name('community.show');
    Route::get('publications', ShowPublicationsuser::class)->name('publicationsuser.show');
    Route::get('tags', ShowTags::class)->name('tags.show');
});

Route::get('contactanos',[MailController::class, "pintarFormulario"])->name('contactanos.pintar');
Route::post('contactanos',[MailController::class, "procesarFormulario"])->name('contactanos.procesar');