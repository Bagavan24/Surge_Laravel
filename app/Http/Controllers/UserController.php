<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Exception;

class UserController extends Controller
{
    //User_SignIn
    function login(Request $request)
    {
        try{
            $user= User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

            $token = $user->createToken('my-app-token')->plainTextToken;
            
            $response = [
                'user' => $user,
                'token' =>$token
            ];
            // return response($response, 200);
            return response([ 'message'=> $response]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //User_SignUp
    public function userRegister (Request $request) 
{
    try{
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','string','min:8','regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'],
        ]);
        
        if($validator->fails()){
            return response([
                'error' => $validator->errors(),
                401
            ]);
        }
        
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $result = $user->save();

        if($result){
            return response([
                'message'=>'User Successfully Created'
            ]);
        }
        else{
            return response([
                'message'=>'Invalid'
            ]);
        }
    }
    catch (\Exception $e) {
        return $e->getMessage();
    }
}

    //Get User
    function Getuser(){
        try{
            return User::get();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //update user
    function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'email' => 'required|email|unique:users,email',
                'password' => ['required','string','min:8','regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'],  
            ]);
            if($validator->fails()){
                return response([
                    'error' => $validator->errors(),
                    401
                ]);
            }
        
            $user=User::find($request->id);
            if(is_null($user)){
                return response()->json('Record not found in database',404);
            }
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $result = $user->save();
    
            
            $result=$user->save();
            if($result){
                return ["result"=>"data is updated "];
            }
            else{
                return ["result"=>"data update failed"];
            }
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
