<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class BlogController extends Controller
{
   public function index()
   {
    $latestPosts = Post::Post()
    ->Published()
    ->latest()
    ->limit(5)
    ->get();
    $posts = Post::Post()->Published()->paginate(5);
    return view('website.blog.index', compact('posts', 'latestPosts'));
   }
   public function show(Post $post)
   {
    $latestPosts = Post::Post()
    ->Published()
    ->latest()
    ->limit(5)
    ->get();
       
    return view('website.blog.show', compact('post', 'latestPosts'));
   }
}
