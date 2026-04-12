<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /** ============================
     *  ADMIN MANAGEMENT (SUPER ONLY)
     *  ============================ */

    // Display all admins
    public function index()
    {
        $this->authorizeSuper();
        $admins = User::where('role', 'admin')->get();

        return view('superadmin.index', compact('admins'));
    }

    // Show form to create a new admin
    public function create()
    {
        $this->authorizeSuper();

        return view('superadmin.create');
    }

    // Store a new admin
    public function store(Request $request)
    {
        $this->authorizeSuper();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $admin, [
            'created_fields' => $admin->toArray(),
        ]);

        return redirect()->route('superadmin.index')->with('success', 'Admin created successfully.');
    }

    // Delete an admin
    public function destroy($id)
    {
        $this->authorizeSuper();

        $admin = User::findOrFail($id);

        if ($admin->role === 'super' || $admin->role === 'developer') {
            return back()->with('error', 'Cannot delete this user.');
        }

        // Save original values before deletion
        $old = $admin->toArray();

        $admin->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $admin, [
            'deleted_fields' => $old,
        ]);

        return back()->with('success', 'Admin deleted successfully.');
    }

    /** ============================
     *  SUPER ADMIN MANAGEMENT (DEVELOPER ONLY)
     *  ============================ */

    // Show form for creating super admin
    public function createSuper()
    {
        $this->authorizeDeveloper();

        return view('superadmin.createSuper');
    }

    // Store new super admin
    public function storeSuper(Request $request)
    {
        $this->authorizeDeveloper();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $super = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'super',
        ]);

        // 🔥 AUDIT TRAIL — log created fields
        AuditService::log('created', $super, [
            'created_fields' => $super->toArray(),
        ]);

        return redirect()->route('developer.dashboard')->with('success', 'Super Admin created successfully.');
    }

    // Delete super admin (developer only)
    public function destroySuper($id)
    {
        $this->authorizeDeveloper();

        $super = User::findOrFail($id);

        if ($super->role !== 'super') {
            return back()->with('error', 'This user is not a super admin.');
        }

        if ($super->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself.');
        }

        // Save original values before deletion
        $old = $super->toArray();

        $super->delete();

        // Log deletion in audit trail
        AuditService::log('deleted', $super, [
            'deleted_fields' => $old,
        ]);

        return back()->with('success', 'Super Admin deleted successfully.');
    }

    /** ============================
     *  DEVELOPER DASHBOARD
     *  ============================ */
    public function developerDashboard()
    {
        $this->authorizeDeveloper();

        $admins = User::where('role', 'admin')->get();
        $supers = User::where('role', 'super')->get();

        return view('superadmin.developer-dashboard', compact('admins', 'supers'));
    }

    /** ============================
     *  AUTHORIZATION HELPERS
     *  ============================ */
    private function authorizeDeveloper()
    {
        if (auth()->user()->role !== 'developer') {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeSuper()
    {
        if (!in_array(auth()->user()->role, ['super', 'developer'])) {
            abort(403, 'Unauthorized');
        }
    }
}
