<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Material;
use App\Models\Item;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.material', [
            'items' => Item::where('material', true)->where('archive', false)->paginate(7),
        ]);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('search');
            $items = Item::where('material', true)
                        ->where('archive', false)
                        ->where('nama', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%")
                        ->get();

            $output = '';
            foreach ($items as $index => $item) {
                $output .= '<tr>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . ($index + 1) . '</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $item->sku . '</h6>
                    </td>
                    <td>
                        <div class="d-flex px-2 py-1">';
                if ($item->gambar) {
                    $output .= '<div><img src="' . asset('storage/' . $item->gambar) . '" class="avatar avatar-sm me-3 border-radius-lg" alt="user1"></div>';
                } else {
                    $output .= '<div><img src="' . asset('assets/img/team-2.jpg') . '" class="avatar avatar-sm me-3 border-radius-lg" alt="user1"></div>';
                }
                $output .= '<div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">' . $item->nama . '</h6>
                                <p class="text-xs font-weight-bold mb-0">' . $item->jenis . '</p>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $item->ukuran . '</h6>
                        <p class="text-xs font-weight-bold mb-0">' . $item->warna . '</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm ' . ($item->stok == 0 ? 'bg-gradient-danger' : ($item->stok <= 10 ? 'bg-gradient-warning' : 'bg-gradient-success')) . '">' . ($item->stok == 0 ? 'Habis' : ($item->stok <= 10 ? 'Menipis' : 'Ada')) . '</span>
                    </td>
                    <td class="text-center">
                        <h6 class="mb-0 text-sm">' . $item->stok . '</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <div class="mt-2">
                            <a href="' . route('l4l', $item->nama) . '" class="btn btn-info">
                                <i class="material-icons">tune</i>
                            </a>
                            <button type="button" class="btn btn-success editBtn" data-bs-toggle="modal" data-bs-target="#modal-form" data-item=\'' . json_encode($item) . '\' data-operation="edit">
                                <i class="material-icons">edit</i>
                            </button>
                            <a href="#" class="btn btn-secondary btn-link archive" data-item-id="' . $item->id . '">
                                <i class="material-icons">archive</i>
                            </a>
                            <form id="archive-form" method="POST" style="display: none;">
                                ' . csrf_field() . method_field('PUT') . '
                            </form>
                        </div>
                    </td>
                </tr>';
            }

            return response()->json($output);
        }
    }

    public function archive(Item $item)
    {
        $item->update(['archive' => true]); // Misalkan Anda punya kolom 'archived'

        Alert::toast('Data Berhasil Di Arsip in','success');
        return redirect()->route('material');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =[
            'id'=>'nullable',
            'nama'=>'required|max:100',
            'jenis'=>'required|max:100',
            'gambar'=>'nullable|image|file|max:5000',
            'stok'=> 'required',
            'material'=> 'required|in:true,false',
            'archive'=> 'required|in:true,false',
        ];

        $data = $request->except('_token'); //Mengambil data tanpa _token

        if ($request->filled('id')) { //ketika $request mempunyai id atau Fungsi Edit

            $Material = Item::where('id', $request->id)->first();
            if($request->sku != $Material->sku) {
                $rules['sku'] ='required|max:100|unique:items';
            }
            $data = $request->validate($rules);
            if($request->file('gambar')) { //pengambilan Gambar
                if($Material->gambar != null){
                    Storage::delete($Material->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('gambar-produk');
            }
            $data['material'] = filter_var($request->material, FILTER_VALIDATE_BOOLEAN);
            $data['archive'] = filter_var($request->archive, FILTER_VALIDATE_BOOLEAN);
            Item::where('id', '=', $request->id)->update($data);
            Alert::toast('Material Terupdate','success');
            return redirect('material');

        }else{  //ketika $request mempunyai id atau Fungsi Tambah Data

            $rules['sku'] ='required|max:100|unique:items';
            $data = $request->validate($rules);
            if($request->file('gambar')) { //pengambilan Gambar
                $data['gambar'] = $request->file('gambar')->store('gambar-produk');
            }
            unset($data['id']); // Menghilangkan kolom ID
            $data['archive'] = filter_var($request->archive, FILTER_VALIDATE_BOOLEAN);
            $data['material'] = filter_var($request->material, FILTER_VALIDATE_BOOLEAN);
            // dd($data);
            Item::create($data);
            Alert::toast('Material Ditambahkan','success');
            return redirect('material');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //
    }
}
