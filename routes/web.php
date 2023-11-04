<?php
use App\Http\Controllers\{ChatController, MailController, TemaoscuroController};
use App\Http\Livewire\{ShowCommunities, ShowCommunity, ShowFriends, ShowNotificaciones, ShowPerfiluser, ShowPublication, ShowPublicationscommunities, ShowPublicationscommunity, ShowPublicationslikes, ShowPublicationssaves, ShowPublicationswelcome, ShowSolicitudamigo, ShowSolicitudfollow, ShowSolicitudparticipante, ShowTags, ShowUsers};
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
Route::get('/', ShowPublicationswelcome::class)->name('inicio');
Route::get('instrucciones', function(){
    return view("livewire.show-instrucciones");
})->name('instrucciones');
Route::get('publication/{id}', ShowPublication::class)->name('publication.show');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
], ['auth', 'verified'])->group(function () {
    Route::get('/dashboard', ShowPublicationscommunities::class)->name('dashboard');
    Route::get('publicationscommunity/{id}', ShowPublicationscommunity::class)->name('publicationscommunity.show');
    Route::get('communities', ShowCommunities::class)->name('communities.show');
    Route::get('community/{id}', ShowCommunity::class)->name('community.show');
    Route::get('perfil/{id}', ShowPerfiluser::class)->name('perfiluser.show');
    Route::get('tags', ShowTags::class)->name('tags.show');
    Route::get('users/{tipo}/{id}', ShowUsers::class)->name('users.show');
    Route::get('likes/{id}', ShowPublicationslikes::class)->name('publicationslikes.show');
    Route::get('saves/{id}', ShowPublicationssaves::class)->name('publicationssaves.show');
    Route::get('notificaciones/{id}', ShowNotificaciones::class)->name('notificaciones.show');
    Route::get('solicitudes', ShowSolicitudparticipante::class)->name('solicitudes.show');
    Route::get('solicitudesamigos', ShowSolicitudamigo::class)->name('solicitudesamigos.show');
    Route::get('friends', ShowFriends::class)->name('friends.show');
    Route::get('solicitudesfollows', ShowSolicitudfollow::class)->name('solicitudesfollows.show');
    Route::get('chat/{tipo}/{tipoid}', [ChatController::class, 'index'])->name('chat.index');
    Route::get('refrescarChat/{tipo}/{tipoid}',[ChatController::class, "abrirChat"])->name('chat.abrirChat');
    Route::post('enviarChat/{tipo}/{tipoid}',[ChatController::class, "store"])->name('chat.store');
});
Route::get('temaoscuro',[TemaoscuroController::class, "cambiartema"])->name('temaoscuro.cambiartema');
Route::get('contactanos',[MailController::class, "pintarFormulario"])->name('contactanos.pintar');
Route::post('contactanos',[MailController::class, "procesarFormulario"])->name('contactanos.procesar');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');