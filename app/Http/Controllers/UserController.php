<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();

        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::where('slug', '<>', 'doctor')->get();

        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::findOrFail($request->input('role_id'));

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        // Create user with selected role
        $role->users()->create($data);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::where('slug', '<>', 'doctor')->get();

        return view('user.edit', $data);
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
        $user = User::findOrFail($id);
        $role = Role::find($request->input('role_id'));

        // Create data for update
        $data = $request->except(['password']);
        if ( $password = $request->input('password') ) $data['password'] = Hash::make($password);

        // Don't change role if current user is doctor
        if ( ! $user->isRole('doctor') ) {
            $user->role()->associate($role); // Associate - change role_id of user
        }

        $user->update($data); // Update user

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent self delete
        if ( ! $user->isMine() ) {
            $user->doctor()->delete(); // Delete data doctor if user role is doctor
            $user->delete(); // Delete user
        }

        return redirect()->route('user.index');
    }
}
