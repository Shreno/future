<?php
namespace App\Liberary;

use Illuminate\View\View;
use App\WebSetting;
use Illuminate\Support\Facades\Auth;
use App\AppSetting;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Notification;

use App\Role;

class Settings 
{
    public function compose(View $view)
    {
        $this->webSetting($view);
        $this->appSetting($view);
        $this->lang($view);
        $this->notificationsBar($view);
    }
    
    private function webSetting(View $view)
    {
        $id = 1;
        $webSetting = WebSetting::findOrFail($id);

         $view->with('webSetting', $webSetting);
    }
    private function appSetting(View $view)
    {
        $id = 1;
        $appSetting = AppSetting::findOrFail($id);

        // permissions
        if (auth()->user()) {
            if (auth()->user()->user_type == 'admin') {
            if (auth()->user()->role_id == null) {
                abort(403, 'Access Denied');
            }
            $role = Role::findOrFail(auth()->user()->role_id);
            
            $permissions = $role->permissions;
            $permissionsTitle = [];
            foreach ($permissions as $permission)
            {
            $permissionsTitle[] = $permission->title;
            } 
            $view->with('permissionsTitle', $permissionsTitle);
        }

        }
        

         $view->with('appSetting', $appSetting);
    }

    private function lang(View $view)
    {
        $lang = LaravelLocalization::getCurrentLocale();

         $view->with('lang', $lang);
    }
    private function notificationsBar(View $view)
    {
        if (auth()->user()) {
            $user = auth()->user();
        if ($user->user_type == 'admin') {
            $notificationsBar = Notification::where('notification_to_type', 'admin')
            ->Unread()
            ->latest()
            ->get();
        } else {
            $notificationsBar = Notification::where('notification_to', $user->id)
            ->Unread()
            ->latest()
            ->get();
        }

         $view->with('notificationsBar', $notificationsBar);
        }
        
    }

    
}