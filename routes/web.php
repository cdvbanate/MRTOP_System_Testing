<?php

use App\Mail\MRTOP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/', function () {
    Mail::to('carlobanatesample@gmail.com')->send(new MRTOP());
    return 'Email sent!';
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

