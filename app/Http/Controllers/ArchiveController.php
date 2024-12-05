<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Item;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.archives', [
            'items' => Item::where('archive', true)->paginate(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function unarchive(Item $item)
    {
        $item->update(['archive' => false]); // Misalkan Anda punya kolom 'archived'

        Alert::toast('Data Berhasil Di Kembalikan','success');
        return redirect('archive');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
