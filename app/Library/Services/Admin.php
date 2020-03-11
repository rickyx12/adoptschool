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

    public function approved(Request $req) {

        $req->validate([
            'monetaryValue' => 'required|numeric',
            'quantity' => 'required|numeric',
            'referrence' => 'required',
            'transactionDate' => 'required'
        ]);

        $requestId = $req->input('requestId');
        $monetaryValue = $req->input('monetaryValue');
        $quantity = $req->input('quantity');
        $referrence = $req->input('referrence');
        $transactionDate = $req->input('transactionDate');

        $data = [
            'requestId' => $requestId, 
            'approved' => 1,
            'monetaryValue' => $monetaryValue, 
            'quantity' => $quantity, 
            'referrence' => $referrence, 
            'transactionDate' => $transactionDate,
            'admin' => Auth::id()
        ];

        DB::update('UPDATE project_stakeholders set approved = :approved, monetary_value_donation = :monetaryValue, quantity_donation = :quantity, reference_document = :referrence, transaction_date = :transactionDate, assisting_admin = :admin WHERE id = :requestId',$data);        
    }

}