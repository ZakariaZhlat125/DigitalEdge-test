<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;



    public  function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $users = $this->user->all();

        // dd($users);
        return view('users.index', compact('users'));
    }



    public  function show($id)
    {
        $user = $this->user->where('id', $id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        $isAdmin = $user->hasRole('admin'); // Check if the user has the 'admin' role
        return view('users.edit', compact('user', 'isAdmin'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->user->findOrFail($id);

            if ($user->hasRole('admin')) {
                $user->removeRole('admin');
            } else {
                $user->addRole('admin');
            }

            return redirect()->route('user.index')->with('success', 'User role updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user role');
        }
    }


    public  function destroy($id)
    {
        try {
            $user = $this->user->findOrFail($id);
            if ($user->hasRole('admin')) {
                $user->removeRole('admin');
            }
            $user->delete();
            return redirect()->route('user  .index')->with('succes', 'User deleted  successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting  User');
        }
    }
}
