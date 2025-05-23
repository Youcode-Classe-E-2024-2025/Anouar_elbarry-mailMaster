<?php

namespace App\Services;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
class UserService
{
    protected $userRepository;
    public function register(array $userData)
    {
        if(User::where('email',$userData['email'])->doesntExist()){
           $userData['password'] = bcrypt($userData['password']);
           $user = User::create($userData);
           return $user;
        }
        return false;
    }

    public function login(array $userData)
    {    
        $user = User::where('email',$userData['email'])->first();
        if($user && Hash::check($userData['password'],$user->password)){
            $user->email_verified_at = now();
            Auth::login($user);
            return $user;
        }else{
            return false;
        }
    }
    public function logout()
    {
         $user = Auth::user();
         if($user){
            $user->tokens()->delete();
            return true;
         }
         return false;
    }

    public function  getUsers(){
        $users = User::getAll();
        return $users;
    }
}
