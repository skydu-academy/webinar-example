<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/http', function () {
    return Http::get('https://postman-echo.com/get?foo1=bar1&foo2=bar2');
});

Route::get('/http-get', function () {
    $response = Http::get('https://postman-echo.com/get?foo1=bar1&foo2=bar2');
    dump($response);
    dump($response->body());
    dump($response->json());
    dump($response->status());
    dump($response->ok());
    dump($response->successful());
    dump($response->serverError());
    dump($response->clientError());
    dump($response->headers());
});

Route::get('/http-post', function () {
    $response = Http::asForm()->post('https://postman-echo.com/post', [
        'nama' => 'Skydu',
        'url' => 'skydu.id'
    ]);
    dump($response->json());
});

Route::get('/http-complete', function () {
    $res = fopen('robots.txt', 'r');
    $response = Http::withHeaders(['X-custom-1' => 'Skydu Academy', 'X-custom-2' => 'academy.skydu.id'])
        ->withToken('exampleofbearertokencontainlongtokenforauthenticationheader')
        ->attach('formname', $res, 'file.txt')
        ->post('https://postman-echo.com/post', [
            [
                'name' => 'nama',
                'contents' => 'Skydu'
            ],
            [
                'name' => 'url',
                'contents' => 'skydu.id'
            ]
        ]);
    dump($response->json());
});


Route::get('/token', function (Request $request) {
    $user = $request->user();
    dd($user->tokens->toArray());
});
Route::get('/token-create/{name}', function (Request $request, $name) {
    $user = $request->user();
    dd($user->createToken($name, ['view-home', 'view-profile']));
});
Route::get('/token-revoke/{id}', function (Request $request, $id) {
    $user = $request->user();
    dd($user->tokens()->where('id', $id)->delete());
});
//=============================###################################################======================================

Route::get('/db-raw/select', function (Request $request) {
    $users = DB::select('select * from users where id = ?', [3]);
    dd($users, $users[0]->name);
});
Route::get('/db-raw/insert', function (Request $request) {
    $faker = \Faker\Factory::create();
    $success = DB::insert(
        'insert into users (name, email, password) values (?, ?, ?)',
        [$faker->name, $faker->email, $faker->word]
    );
    dd('sukses gak?', $success);
});
Route::get('/db-raw/update', function (Request $request) {
    $success = DB::update(
        'update users set name = ?, email = ? where id = ?',
        ['Yahyaman', 'yahya@skydu.com', 3]
    );
    dd('Berapa row yg kena? '.$success);
});
Route::get('/db-raw/delete', function (Request $request) {
    $success = DB::delete(
        'delete from users where id = ?',
        [4]
    );
    dd('Berapa row yg kena? '.$success);
});

//Query Builder

Route::get('/db-query/select', function (Request $request) {
    $users = DB::table('users')->first();
    dd($users);
});
Route::get('/db-query/insert', function (Request $request) {
    $faker = \Faker\Factory::create();
    $users = DB::table('users')
        ->insert([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->word,
        ]);
    dd($users);
});
Route::get('/db-query/update', function (Request $request) {
    $success = DB::table('users')
        ->update([
            'created_at' => date('Y-m-d H:i:s'),
            'password' => '123456'
        ]);
    dd($success);
});
Route::get('/db-query/delete', function (Request $request) {
    $affected = DB::table('users')
        ->where('name', 'like', '%yahya%')
        ->delete();
    dd($affected);
});

// Eloquent model
Route::get('/db-eloquent/insert', function (Request $request) {
    $faker = \Faker\Factory::create();
    $user = \App\User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $faker->word,
        ]);
    dd($user);
});
Route::get('/db-eloquent/update', function (Request $request) {
    $affected = \App\User::where('id', 5)->update([
            'created_at' => date('Y-m-d H:i:s'),
            'password' => '123456'
        ]);
    dd($affected);
});
Route::get('/db-eloquent/delete', function (Request $request) {
    $affected = \App\User::where('name', 'like', '%yahya%')->delete();
    dd($affected);
});

// Eloquent magic
Route::get('/db-eloquent/magic-crud', function (Request $request) {
    $faker = \Faker\Factory::create();
    /*$user = new \App\User();
    $user->name = 'OOP_'.$faker->name;
    $user->email = 'OOP_'.$faker->email;
    $user->password = $faker->word;
    $user->save();
    dd($user);*/

    //select
    /*$user = \App\User::where('name', 'OOP_')->first();
    dd($user);*/

    /*$user = \App\User::where('name', 'like', 'OOP_%')->first();
    //dd($user);

    //update
    $user->name = substr($user->name, '4');
    $user->email = 'email@baru.com';
    $user->save();

    dd($user);*/

    //delete
    $user = \App\User::find(5);
    dump($user);
    $user->delete();
    dd(\App\User::find(5));
});

Route::get('/db-eloquent/magic-mutator', function (Request $request) {
    $user = \App\User::find(6);
    /*dd($user->name);*/

    /*$user->name = 'Nama Saya Budi';
    $user->save();
    dd($user);*/

    dd($user->short_bio);
});

Route::get('/db-eloquent/magic-scope', function (Request $request) {
    $users = \App\User::registeredToday()->get();
    dd($users);
});

Route::get('/db-eloquent/magic-relation', function (Request $request) {
    $user = \App\User::find(3);

    $post = new \App\Post();
    $post->title = 'Judul post';
    $post->content = 'Konten post';
    $user->posts()->save($post);

    dump($user->posts());
    //dump($user->posts);

    $attachment1 = \App\Attachment::create([
        'attachment_type' => 'image'
    ]);
    $post->refresh();
    $post->attachments()->save($attachment1);

    $comment = \App\Comment::create([
        'text' => 'ini komen',
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);
    $attachment2 = \App\Attachment::create([
        'attachment_type' => 'file'
    ]);
    $comment->attachments()->save($attachment2);
});
