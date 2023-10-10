<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branch;

class BranchController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_branch', ['only'=>'index', 'show']);
    $this->middleware('permission:add_branch', ['only'=>'create', 'store']);
    $this->middleware('permission:edit_branch', ['only'=>'edit', 'update']);
    $this->middleware('permission:delete_branch', ['only'=>'destroy']);
  }
    public function index()
    {
        $branches = Branch::get();
        return view('admin.website.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.website.branch.add');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title_en'      => 'required',
            'title_ar'      => 'required',
        ]);
        
        
        $branch = Branch::create($request->all());

        if ($branch) {
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
        
        return redirect()->route('branches.index')->with($notification);
    }

    public function show($id)
    {
        //
    }
    public function edit(Branch $branch)
    {
        return view('admin.website.branch.edit', compact('branch'));
    }

    
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
       
        if ($branch->update($request->all())) {
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
        
        return redirect()->route('branches.index')->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        if ($branch) {
            $branch->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
