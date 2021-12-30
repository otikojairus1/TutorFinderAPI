<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        // dd($request);
        $rules = [
            'emailId' => 'unique:users|required',
            'AccountType' => 'required',
            'password' => 'required',
        ];

        $input     = $request->only('emailId', 'AccountType','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $emailId = $request->emailId;
        $AccountType = $request->AccountType;
        $password = $request->password;
       // $phone = $request->phone;
        $user     = User::create(['emailId' => $emailId, 'accountType' => $AccountType, 'password' => Hash::make($password)]);
        //$token = $request->name->createToken('accessToken');
        return response()->json(['success' => true, 'message' => 'user has registered successfully.', "data"=>$user]);
       // return response()->json(["woork"=>"yee"]);
    }


    public function store(Request $request){
        // dd($request);
        $rules = [
            'emailId' => 'unique:accounts|required',
            'AccountType' => 'required',
            'password' => 'required',
        ];

        $input     = $request->only('emailId', 'AccountType','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = new Account();
        $user->emailId = $request->emailId;
        $user->accountType = $request->AccountType;
        $user->password = $request->password;

       if( $user->save() ){
           return response()->json(['success' => true, 'message' => 'user has registered successfully.', "data"=>$user]);
       }else{
           return response()->json(['success' => false, 'error' => 'we encountered an error']);
       }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login1(){
        if(Auth::attempt(['emailId' => request('emailId'), 'password' => request('password')])){
            $user = Auth::user();
            return response()->json(['success'=>true,'userDetails'=>$user ], 200);
        }
        else{
            return response()->json(['success'=>false,'error'=>'wrong login credentials' ], 401);
        }
    }

    public function login(Request $request){
        $rules = [
            'emailId' => 'required',
            'password' => 'required',
        ];

        $input     = $request->only('emailId','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $emailId = $request->emailId;
        $password = $request->password;

        $userlogged = Account::where(['emailId'=>$emailId, 'password'=>$password])->first();

        if($userlogged){
            return response()->json(['success'=>true,'data'=>$userlogged ], 200);
        }else{
            return response()->json(['success'=>false,'error'=>'wrong login credentials' ],200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function allTutors()
    {
        $tutors = Account::where('accountType',"Tutor")->get();
        return response()->json(['success'=>true,'Data'=>$tutors ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
