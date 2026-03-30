<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\EmployeeProfile;
use App\Models\EmployeeDocument;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = \App\Models\User::with(['distributor', 'outlets'])
            ->where('id', '!=', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('distributor', function ($dq) use ($search) {
                            $dq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $distributors = \App\Models\Distributor::all();
        return view('admin.users.create', compact('distributors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . \App\Models\User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'in:admin,ba'],
            'distributor_id' => ['required_if:role,ba', 'nullable', 'exists:distributors,id'],
            'outlets' => ['array'],
            'outlets.*' => ['exists:outlets,id'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Profile Validation
            'nik' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'dob' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'employment_status' => ['nullable', 'in:Tetap,Kontrak,Magang'],
            'join_date' => ['nullable', 'date'],

            // Documents Validation
            'documents' => ['nullable', 'array'],
            'documents.ktp' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.npwp' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.kontrak_kerja' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.ijazah' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.sertifikat' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
            'distributor_id' => $request->distributor_id,
            'photo_path' => $photoPath,
            'is_active' => true,
        ]);

        if ($request->role === 'ba') {
            if ($request->filled('outlets')) {
                $user->outlets()->sync($request->outlets);
            }

            // Create Profile
            EmployeeProfile::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'address' => $request->address,
                'employment_status' => $request->employment_status,
                'join_date' => $request->join_date,
            ]);

            // Create Documents
            if ($request->has('documents')) {
                foreach ($request->file('documents', []) as $type => $file) {
                    if ($file) {
                        $path = $file->store("employee_documents/{$user->id}", 'public');
                        EmployeeDocument::create([
                            'user_id' => $user->id,
                            'type' => $type,
                            'file_path' => $path,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $user = \App\Models\User::with('outlets')->findOrFail($id);
        $distributors = \App\Models\Distributor::all();
        return view('admin.users.edit', compact('user', 'distributors'));
    }

    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,ba'],
            'distributor_id' => ['required_if:role,ba', 'nullable', 'exists:distributors,id'],
            'outlets' => ['array'],
            'outlets.*' => ['exists:outlets,id'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Profile Validation
            'nik' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'dob' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'employment_status' => ['nullable', 'in:Tetap,Kontrak,Magang'],
            'join_date' => ['nullable', 'date'],

            // Documents Validation
            'documents' => ['nullable', 'array'],
            'documents.ktp' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.npwp' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.kontrak_kerja' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.ijazah' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'documents.sertifikat' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'distributor_id' => $request->distributor_id,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo_path) {
                Storage::disk('public')->delete($user->photo_path);
            }
            $updateData['photo_path'] = $request->file('photo')->store('profile_photos', 'public');
        }

        $user->update($updateData);

        if ($request->role === 'ba') {
            $user->outlets()->sync($request->outlets ?? []);

            // Update or Create Profile
            EmployeeProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nik' => $request->nik,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'employment_status' => $request->employment_status,
                    'join_date' => $request->join_date,
                ]
            );

            // Update or Create Documents
            if ($request->hasFiles('documents')) {
                foreach ($request->file('documents', []) as $type => $file) {
                    if ($file) {
                        $existingDoc = EmployeeDocument::where('user_id', $user->id)->where('type', $type)->first();
                        if ($existingDoc && $existingDoc->file_path) {
                            Storage::disk('public')->delete($existingDoc->file_path);
                        }

                        $path = $file->store("employee_documents/{$user->id}", 'public');
                        EmployeeDocument::updateOrCreate(
                            ['user_id' => $user->id, 'type' => $type],
                            ['file_path' => $path]
                        );
                    }
                }
            }
        } else {
            $user->outlets()->detach();
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            ]);
            $user->update(['password' => \Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function toggle(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Akun pengguna {$user->name} berhasil {$status}.");
    }

    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Delete files
        if ($user->photo_path)
            Storage::disk('public')->delete($user->photo_path);
        foreach ($user->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna dihapus.');
    }
}
