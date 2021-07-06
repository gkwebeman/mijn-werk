<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\Club;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Checking if the user has the rights to get to the user page.
     * Getting all the users and roles to show on the user page.
     */
    public function index()
    {
        if (Auth::user()->roles_id !== 1){
            abort('403');
        }
        $users = User::all() ?? [];
        $roles = Role::get();

        return view('pages.user.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Getting the data of the user.
     */
    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            return [
                'id' => $user->id,
                'name' => $user->firstname . ' '. $user->prefix . ' ' . $user->lastname,
                'role_id' => $user->roles_id,
            ];
        }

        $user->club = Club::where('id', $user->clubs_id)->first();

        return view('pages.user.show', ['user' => $user]);
    }

    /**
     * Funciton to save the new role of the user.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->roles_id !== 1){
            abort('403');
        }
        DB::beginTransaction();

        try {
            $user->roles_id = $request->role_id;
            $user->save();
        } catch(Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Er is iets fout gegaan.');
        }

        DB::commit();
        return $user;
    }

    /**
     * Saving the new image of the user.
     */
    public function saveUserImage(User $user, UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            if($user->picture) {
                Storage::deleteDirectory('user/' . $user->id);
            }

            $user->picture = $request->picture->getClientOriginalName();

            $user->save();

            $request->picture->StoreAs('user/' . $user->id, $user->picture);

        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
        DB::commit();
        return back();
    }

    /**
     * Deleting the image from the user in the database.
     * And delete the directory where the image is stored.
     */
    public function deleteUserImage(User $user)
    {
        DB::beginTransaction();
        try {
            $user->picture = NULL;
            $user->save();

            Storage::deleteDirectory('user/'.$user->id);
        } catch(Exception $e) {
            DB::rollback();
            return $e;
        }
        DB::commit();
        return $user;
    }
}
