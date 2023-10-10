<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $actionName)
    {
        if (auth()->user()->role_id == null) {
            //abort(403, 'Access Denied');
          //  flash("You don't have access to this content !")->error();
            $notification = array(
            'message' => '<h3>You don\'t have access to this content !</h3>',
            'alert-type' => 'danger'
        );
            return back()->with($notification);
        }
        $role = Role::findOrFail(auth()->user()->role_id);
        
        $permissions = $role->permissions;
        $permissionsTitle = [];
        foreach ($permissions as $permission)
        {
        $permissionsTitle[] = $permission->title;
        } 
       // dd($permissionsTitle);        
        if (in_array($actionName, $permissionsTitle))
         {
           // authorized request
           return $next($request);
         }else{
            // abort(403, 'Access Denied');
             $notification = array(
            'message' => '<h3>You don\'t have access to this content !</h3>',
            'alert-type' => 'danger'
        );
            return back()->with($notification);
         }
    }
}
