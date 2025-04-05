<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    use ValidatesRequests;

    public function list(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('show_users')) abort(401);

        $query = User::select('*');
        $query->when($request->keywords, fn($q) => $q->where("name", "like", "%$request->keywords%"));
        $users = $query->get();

        return view('users.list', compact('users'));
    }

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole('customer');
        $user->save();

        return redirect('/');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        return redirect('/');
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach ($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach (Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['array'],
            'permissions' => ['array'],
            'credit' => ['nullable', 'numeric', 'min:0']
        ]);

        $user->update([
            'name' => $request->name,
            'credit' => $request->credit ?? $user->credit,
        ]);

        if (auth()->user()->hasRole('Admin')) {
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function delete(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('delete_users')) abort(401);

        // $user->delete(); // Optional, depends on whether you want soft delete

        return redirect()->route('users');
    }

    public function editPassword(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user)
    {
        if (auth()->id() == $user?->id) {
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                Auth::logout();
                return redirect('/');
            }
        } else if (!auth()->user()->hasPermissionTo('edit_users')) {
            abort(401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function addCredit(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('Employee')) {
            abort(403, 'Unauthorized action.');
        }

        if (!$user->hasRole('customer')) {
            return redirect()->back()->with('error', 'You can only add credit to customers.');
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $user->increment('credit', $request->amount);

        return redirect()->back()->with('success', 'Credit added successfully.');
    }

    // ✅ Midterm: Show Users by Role
    public function showUsersByRole(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('show_users')) abort(403);

        $role = $request->get('role'); // optional

        $query = User::query();

        if ($role) {
            $query->role($role);
        }

        $users = $query->get();

        return view('users.by_role', compact('users', 'role'));
    }

    // ✅ Midterm: Show My Credit
    public function showCredit()
    {
        $user = auth()->user();
        return view('users.credit', compact('user'));
    }

    public function create()
{
    $roles = Role::all();
    return view('users.create', compact('roles'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'roles' => 'required|array',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'credit' => 0, // default credit
    ]);

    $user->syncRoles($request->roles);

    return redirect()->route('users')->with('success', 'User created successfully.');
}

public function listCustomers()
{
    // Get all users with the 'Customer' role
    $customers = User::role('Customer')->get();

    // Return the view and pass the customers data to it
    return view('users.list-customer', compact('customers'));
}

public function chargeCredit(Request $request, $id)
{
    // Validate that the credit is a positive number
    $validated = $request->validate([
        'credit' => 'required|numeric|min:0.01',  // Credit must be a positive value
    ]);

    // Find the customer by ID
    $customer = User::findOrFail($id);

    // Charge the customer's credit
    $customer->credit += $validated['credit'];  // Add the credit value to the existing balance

    // Save the updated credit to the database
    $customer->save();

    // Redirect back with a success message
    return redirect()->route('customers.list')->with('success', 'Credit charged successfully.');
}

}
