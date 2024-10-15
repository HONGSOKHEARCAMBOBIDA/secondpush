<?php

namespace App\Http\Controllers;

use App\Models\User; // Correctly import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller // Correct class name
{
    public function index()
    {
        $users = User::all(); // Use plural for consistency
        return response()->json($users); // Return users as JSON
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = $request->all();
        $user['password'] = bcrypt($user['password']); // Hash the password

        $userdata = User::create($user);

        return response()->json(['message' => 'Created successfully'], 201); // Correct response syntax
    }
    // public function update(Request $request)
    // {
    //     DB::beginTrasaction();
    //     $result['status']=200;
    //     try
    //     {
    //         User::where("id",$request->id)->update($request->all());
    //         DB::commit();
    //         $result['message']='update successfully'
    //     }
    //     catch(\Throw $th)
    //     {
    //         DB::rollBack();
    //         $result['status']=500;
    //         $result['messag']=$th->getMessage();

    //     }
    // }
    public function update(Request $request)
    {
        DB::beginTransaction(); // Correct spelling of beginTransaction
        $result['status'] = 200;
        try {
            User::where("id", $request->id)->update($request->all());
            DB::commit();
            $result['message'] = 'Updated successfully'; // Added semicolon and corrected spelling
        } catch (\Throwable $th) { // Use \Throwable instead of \Throw
            DB::rollBack();
            $result['status'] = 500;
            $result['message'] = $th->getMessage(); // Corrected spelling
        }

        return response()->json($result); // Return the result as JSON
    }
}
