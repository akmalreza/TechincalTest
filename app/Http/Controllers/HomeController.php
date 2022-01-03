<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = User::get();

        return view('home')->with(compact('data'));
    }

    public function edit(Request $request)
    {
        $data = User::findOrFail($request->id);

        return view('edit')->with(compact('data'));
    }

    /**
     * Update user data
     * 
     * @param string $request->name
     * @param string $request->position
     * @param string $request->status
     * @param bigInt $request->id
     * @return json
     */
    public function update(Request $request)
    {
        try {
            // Validate all requests parameters
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'status' => 'required',
                'position' => 'required|max:255'
            ]);
    
            // Return error with message if validator fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => implode(' ', $validator->errors()->all())
                ]);
            }
            
            $data = User::findOrFail($request->id);
            $data->name = $request->name;
            $data->position = $request->position;
            $data->status = $request->status;
            $data->save();
    
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    /**
     * Create new / store user's data to database
     * 
     * @param string $request->email
     * @param string $request->name
     * @param string $request->password
     * @param string $request->status
     * @param string $request->position
     * @return json
     * @return abort 500
     */
    public function store(Request $request)
    {
        // Using try catch to generalize all throwable / exception
        try {
            // Validate all requests parameters
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users',
                'name' => 'required|max:255',
                'password' => 'required|min:8',
                'status' => 'required',
                'position' => 'required|max:255'
            ]);
    
            // Return error with message if validator fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => implode(' ', $validator->errors()->all())
                ]);
            }
            
            // Create new model instance
            $data = new User;

            // Assign all columns value
            $data->name = $request->name;
            $data->position = $request->position;
            $data->status = $request->status;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);

            // Store data to database
            $data->save();
    
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    /**
     * Get users detail
     * 
     * @param int $request->user_id
     * @return json
     */
    public function detail(Request $request)
    {
        // Try to find data or abort 404 if data not found
        $data = User::findOrFail($request->user_id);

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Delete data from database using given user_id
     * 
     * @param int $request->user_id
     * @return json
     */
    public function delete(Request $request)
    {
        // Find the user data and delete
        $data = User::findOrFail($request->user_id)->delete();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Render landing page for create user
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('create');
    }
}
