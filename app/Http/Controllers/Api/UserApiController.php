<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Auth;

class UserApiController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:50',
            'role' => 'required|string|max:10'
        ],[
            'name.required' => 'Name is Required',
            'name.string' => 'Name Must Be String',
            'email.required' => 'Email is Required',
            'email.unique' => 'Email Has Already Been Taken',
            'password.required' => 'Password is Required',
            'password.string' => 'Password Must Be String',
            'password.min' => 'Password Must Be At Least 8 Character',
            'password.max' => 'Password Must Not Be Greater Than 50 Characters',
            'role.required' => 'Role is Required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password),
            'created_by' => $request->name,
            'updated_by' => $request->name,
            'role' => $request->role,
        ]);

        //User created, return success response
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'status' => 400,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Could not create token.',
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'token' => $token,
            'user' => [
                'email' => $request->email,
                'password' => $request->password,
                'id_user' => Auth::id(),
                'role' => Auth::user()->role
            ]
        ]);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'status' => 200,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function get(Request $request)
    {
        $select = User::select('users.id',
                                'users.name', 
                                'users.email', 
                                'users.email_verified_at',
                                'users.created_dt', 
                                'users.updated_dt', 
                                'users.created_by',
                                'users.updated_by',
                                'users.role as code_role');
        // by name
        if( $request->name){
            $data = $select
                    ->where('name', 'LIKE', "%" . $request->name . "%")
                    ->orderBy("name")                
                    ->paginate(10);
        }
        // by email
        if( $request->email){
            $data = $select
                    ->where('email', 'LIKE', "%" . $request->email . "%")
                    ->orderBy("email")                
                    ->paginate(10);
        }
        // by name and email
        if( $request->name && $request->email){
            $data = $select
                    ->where('name', 'LIKE', "%" . $request->name . "%")
                    ->where('email', 'LIKE', "%" . $request->email . "%")
                    ->orderBy("name")
                    ->orderBy("email")
                    ->paginate(10);
        }
        // all
        if( !$request->name && !$request->email ){
            $data = $select
                    ->orderBy("name")
                    ->orderBy("email")
                    ->paginate(10);
        } 
        
        if ($data->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'Data Not Found',
                'data' => $data
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $data
            ], Response::HTTP_OK);
        }
    }

    public function show($id)
    {
        $user = User::select('users.id',
                            'users.name', 
                            'users.email', 
                            'users.email_verified_at',
                            'users.created_dt', 
                            'users.updated_dt', 
                            'users.created_by',
                            'users.updated_by',
                            'users.role')
                            ->find($id);
        
        if (!$user) {
            return response()->json([
                'status' => 200,
                'message' => 'Data Not Found',
                'data' => null
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $user
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password', 'role', 'updated_dt', 'updated_by');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:10',
            'updated_by' => 'string'
        ],[
            'name.required' => 'Name is Required',
            'name.string' => 'Name Must Be String',
            'email.required' => 'Email is Required',
            'email.unique' => 'Email Has Already Been Taken',
            'role.required' => 'Role is Required',
        ]);

        //Request is valid, update user
        $user = $user->update([
        	'name' => $request->name,
        	'email' => $request->email,
            'role' => $request->role,
            'updated_dt' => date("Y-m-d H:i:s"),
            'updated_by' => $request->name
        ]);

        //User updated, return success response
        return response()->json([
            'status' => 200,
            'message' => 'Data updated successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get all data perda by id
        $user = User::where('id', '=', $id)->get();
        //count data for True or false
        $count = count($user);
        //check for delete
        if($count === 1){
            //delete
            if ($id==Auth::id()){
                return response()->json([
                    'status' => 400,
                    'message' => "You can't delete this data"
                ], 400);    
            } else if ($id!=Auth::id()) {
                //delete if not active user
                $user[0]->delete();
                //respon success
                return response()->json([
                    'status' => 200,
                    'message' => 'Data deleted successfully'
                ], Response::HTTP_OK);
            }
        } else {
            //response id not found
            return response()->json([
                'status' => 200,
                'message' => 'Data deleted successfully'
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function forgot(User $user, $email)
    {
        //get all data user by email
        $user = User::where('email', '=', $email)->get();
        //count data for True or false
        $count = count($user);
        //check for delete
        if($count === 1){
            //Request is valid, update user
            $user[0]->update([
                'password' => bcrypt($email)
            ]);

            //User updated, return success response
            return response()->json([
                'status' => 200,
                'message' => 'Password updated successfully',
                'data' => $user
            ], Response::HTTP_OK);
        } else {
            //response id not found
            return response()->json([
                'status' => 404,
                'message' => 'Email user not Found!'
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changepassword(Request $request, User $user)
    {
        //Validate data
        $data = $request->only('password', 'updated_dt', 'updated_by');
        $validator = Validator::make($data, [
            'password' => 'required|string'
        ],[
            'password.required' => 'Password is Required',
            'password.string' => 'Password Must Be String',
        ]);

        //Request is valid, update user
        $user = $user->update([
        	'password' => bcrypt($request->password),
            'updated_dt' => date("Y-m-d H:i:s"),
            'updated_by' => $request->name
        ]);

        //User updated, return success response
        return response()->json([
            'status' => 200,
            'message' => 'Data updated successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

}
