<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Hapus Akun ?';
        $text = "Apakah Yakin Mau Di Hapus?";
        confirmDelete($title, $text);

        return view('pages.laravel-examples.user-management', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.laravel-examples.new-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =[
            'name'=>'required|max:100',
            'email'=>'required|email',
            'phone'=>'nullable',
            'is_admin'=>'required',
            'location'=> 'nullable',
            'password'=> 'required|max:60',
        ];


        $data = $request->validate($rules);
        $data['is_admin'] = filter_var($request->is_admin, FILTER_VALIDATE_BOOLEAN);
        // dd($data);
        User::create($data);
        Alert::toast('Akun Ditambahkan','success');
        return redirect('user-management');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);

        return view('pages.laravel-examples.edit-user', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules =[
            'id'=>'required',
            'name'=>'required|max:100',
            'email'=>'required|email',
            'phone'=>'nullable',
            'is_admin'=>'required',
            'location'=> 'nullable',
            'password'=> 'nullable',
        ];

        $data = $request->validate($rules);

        if ($request->password == null){
            unset($data['password']);
        }
        $data['is_admin'] = filter_var($request->is_admin, FILTER_VALIDATE_BOOLEAN);
        // dd($data);

        User::where('id', $id)->update($data);
        Alert::toast('Akun Terupdate','success');
        return redirect('user-management');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        Alert::toast('Barang Terhapus','success');
        return redirect('user-management');
    }
}
