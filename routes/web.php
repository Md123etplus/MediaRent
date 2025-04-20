<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view(view: 'landing');
});
Route::get('/register',function(){
    return view('register.sign-up');
});
Route::get('/login',function(){
    return view('login.login');
});
Route::get('/categories',function(){
    return view('categories.main');
});
Route::get( '/search',function(){//vous pouvez changer apres
    return view('search.main');
});
Route::get( '/premium',function(){//vous pouvez changer apres
    return view('premium.main');
});
Route::get( '/blog',function(){//vous pouvez changer apres
    return view('blog.main');
});
