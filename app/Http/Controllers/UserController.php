<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
  public function index(Request $request) {
    $query = User::query();
    $users = $query->orderBy('created_at', 'desc')->paginate(15);
    return view('admin.users.index', compact('users'));
  }

  public function create() {
    return view('admin.users.create');
  }

  public function store(Request $request) {
    $user = new User();
    $user->name = $request->name;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->password = $request->password;
    $user->type = $request->type;
    $user->save();

    return redirect()->route('admin.users.index');
  }

  public function show(User $user) {
    //
  }

  public function edit(User $user) {
    //
  }

  public function update(Request $request, User $user) {
    //
  }

  public function destroy(User $user) {
    //
  }
}
