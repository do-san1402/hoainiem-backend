<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;

function admin(){
    $user = User::select('user_type')->where('id',Auth::id())->first();
    if($user->user_type == 1){
        return true;
    }else{
        return false;
    }
}