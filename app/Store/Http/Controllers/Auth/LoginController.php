<?php

namespace App\Store\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Store\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Setting\SettingRepositoryInterface;

class LoginController extends Controller
{
    //
    private $login;
    protected $repoSetting;

    public function __construct(SettingRepositoryInterface $repoSetting)
    {
        parent::__construct();
        $this->repoSetting = $repoSetting;
    }

    public function getView(){
        return [
            'index' => 'stores.auth.login'
        ];
    }

    public function index(){
        $logo = $this->repoSetting->getValueByKey('site_logo') ?? config('custom.images.logo');
        return view($this->view['index'], compact('logo'));
    }

    public function login(LoginRequest $request){
      
        $this->login = $request->validated();
        
        if($this->resolve()){

            $request->session()->regenerate();
            
            return redirect()->intended(route('store.dashboard'))->with('success', __('notifySuccess'));
            
        }
        return back()->with('error', __('LoginFail'));
    }

    protected function resolve(){

        return Auth::guard('store')->attempt($this->login, true) ? true : false;
    }
}
