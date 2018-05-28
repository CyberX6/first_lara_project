<?php
use App\Post;
use App\User;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/contact', function () {
//    return "hi about page";
//});
//
//Route::get('/contact', function () {
//    return "hi I am contact";
//});
//
//Route::get('/post/{id}/{name}', function ($id, $name) {
//    return "This is post number ".$id." and name is ".$name;
//});
//
//Route::get('/admin/posts/example', array('as' => 'admin.home', function () {
//    $url = route('admin.home');
//
//    return "This url is ".$url;
//}));

//Route::get('/insert', function() {
//    DB::insert('INSERT INTO posts (title, body) VALUES (?, ?)', ['PHP with Laravel', 'Laravel is the best thing that happened to PHP']);
//});

//Route::get('/read', function () {
//   $results = DB::select('SELECT * FROM posts WHERE id = ?', [1]);
//   foreach ($results AS $result) {
//       return $result->title."<br>";
//   }
//});
//
//Route::get('/update', function () {
//   $updated = DB::update('UPDATE posts SET title="Update title" WHERE id=?', [1]);
//   return $updated;
//});
//
//Route::get('/delete', function () {
//    DB::delete('DELETE FROM posts WHERE id=?', [1]);
//});

Route::get('/read', function () {
    $posts = Post::all();
    foreach ($posts as  $post) {
        return $post->title;
    }
});

Route::get('/find', function () {
    $post = Post::find(2);
    return $post->title;
});

Route::get('/findwhere', function () {
    $post = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
    return $post;
});

Route::get('/findmore', function () {
    $posts = Post::findOrFail(4);
    return$posts;
});

Route::get('/basicinsert', function () {
    $post = new Post;
    $post->title    = "new ORM title";
    $post->body     = 'WOW eloquent is really cool, look at this content';
    $post->save();
});

Route::get('/basicinsert2', function () {
    $post = Post::find(2);
    $post->title    = "new ORM title2";
    $post->body     = 'WOW eloquent is2 really cool, look at this content';
    $post->save();
});

Route::get('/create', function () {
   Post::create(['title' => 'the create method', 'body' => 'safa']);
});

Route::get('/update', function () {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'NEW PHP TITLE', 'body' => 'I am the boss']);
});

Route::get('/delete', function () {
    $post = Post::find(2);
    $post->delete();
});

Route::get('/delete2', function () {
    Post::destroy([4,5]);
    Post::where('is_admin', 0)->delete();
});

Route::get('/softdelete', function () {
    Post::find(3)->delete();
});

Route::get('/readsoftdelete', function () {
//    $post = Post::find(3);
//    return $post;
    $post = Post::withTrashed()->where('id', 3)->get();
    return $post;

//    $post = Post::onlyTrashed()->where('id', 3)->get();
//    return $post;
});

Route::get('/restore', function () {
    Post::withTrashed()->where('is_admin', 0)->restore();
});

Route::get('/forcedelete', function () {
    Post::withTrashed()->where('is_admin', 0)->forceDelete();
});

Route::get('/user/{id}/post', function ($id) {
   return User::find($id)->post->title;
});

Route::get('/post/{id}/user', function ($id) {
    return Post::find($id)->user->name;
});

Route::get('/posts', function () {
    $user = User::find(1);

    foreach ($user->posts as $post) {
        echo $post->title." <br>";
    }
});

//Route::get('/post/{id}', 'PostsController@index');

//Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@contact');

Route::get('/post/{id}/{name}/{password}', 'PostsController@show_post');