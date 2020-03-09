<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\AdminInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Admin implements AdminInterface
{

    public function register(Request $req) 
    {
      
        $req->validate([
            'emailAddress' => 'required',
            'password' => 'required',
            'completeName' => 'required'
        ]);     

        $email = $req->input('emailAddress');
        $password = Hash::make($req->input('password'));
        $completeName = $req->input('completeName');

        $data = [$email, $password, $completeName];

        DB::insert('INSERT INTO admin_users(email, password, complete_name) VALUES (?, ?, ?)', $data);
    }

}