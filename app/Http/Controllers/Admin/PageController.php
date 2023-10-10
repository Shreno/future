<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;

class PageController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_page', ['only'=>'index', 'show']);
    $this->middleware('permission:add_page', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_page', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_page', ['only'=>'destroy']);
  }
    public function index()
    {
        $pages = Post::where('post_type', 'page')->get();
        return view('admin.website.page.index', compact('pages'));
    }

    public function create()
    {
        
        return view('admin.website.page.add');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'title_en'   => 'required',
            'title_ar'   => 'required',
            'slug'       => 'required|unique:posts',
        ]);

        $pageData = $request->all();
        $pageData['post_type'] = 'page';

        if ($request->hasFile('image')) {
            $request->validate([
                'image'      => 'mimes:jpeg,jpg,png',
            ]);
            $image = 'website/page/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
             $pageData['image'] = $image;
            }
        }
        $request->user()->posts()->create($pageData);
        $notification = array(
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('pages.index')->with($notification);
    }

    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Post::findOrFail($id);
        return view('admin.website.page.edit', compact('page'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en'   => 'required',
            'title_ar'   => 'required',
            'slug'       => 'required|unique:posts,slug,'.$id,
        ]);
        $pageData = $request->all();
        $page = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image'      => 'mimes:jpeg,jpg,png',
            ]);
            Storage::delete('public/'.$page->image);
            $image = 'website/page/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public' , $image);
            if ($uploaded) {
             $pageData['image'] = $image;
            }
        }
        if ($page->update($pageData)) {
            $notification = array(
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error'
            );
        }
        
        return redirect()->route('pages.index')->with($notification); 
    }

    public function destroy($id)
    {
        $page = Post::findOrFail($id);
        $delete =  Storage::delete('public/'.$page->image);
        $page->delete();
        
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
