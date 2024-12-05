<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Dispatching;
use App\Models\Pivot_dispatching;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DispatchingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Delete Data!';
        $text = "Apa beneran mau hapus data ini?";
        confirmDelete($title, $text);

        $dispatchings = Dispatching::with('Pivot_dispatchings.item')->paginate(7);

        return view('pages.dispatching.dispatching',[
            'dispatchings' =>$dispatchings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dispatching.new-dispatching');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =[
            'no_transaksi' => 'required|max:100|unique:Dispatchings',
            'sku' => 'required|array',
            'sku.*' => 'required|max:100',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|max:100',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer',
            'tanggal' => 'required|date',
            'file_bukti' => 'nullable|file|max:5000',
        ];
        // dd($request);
        $data = $request->validate($rules);

        if ($request->hasFile('file_bukti')) {
                $data['file_bukti'] = $request->file('file_bukti')->store('bukti-barang-keluar');
            }

        $dispatchingData = [
        'no_transaksi' => $data['no_transaksi'],
        'tanggal' => $data['tanggal'],
        ];

        if (isset($data['file_bukti'])) {
        $dispatchingData['file'] = $data['file_bukti'];
        }

        Dispatching::create($dispatchingData);

        foreach ($data ['sku'] as $key => $sku) {
            Pivot_dispatching::create([
                'dispatching_transaksi' => $data['no_transaksi'],
                'item_sku' => $sku,
                'jumlah' => $data['jumlah'][$key],
            ]);

            $item = Item::where('sku', $sku)->first();
            // dd($item);
            if ($item) {
            $item->stok -= $data['jumlah'][$key];
            $item->save();
            }
        }

        Alert::toast('Barang Keluar Ditambahkan','success');
        return redirect('dispatching');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispatching $dispatching)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $dispatching = Dispatching::with('Pivot_dispatchings.item')->findOrFail($id);

        return view('pages.dispatching.edit-dispatching', compact('dispatching'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'no_transaksi' => 'required|max:100',
            'sku' => 'required|array',
            'sku.*' => 'required|max:100',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|max:100',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer',
            'tanggal' => 'required|date',
            'file_bukti' => 'nullable|file|max:5000',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Update data pada tabel `dispatching`
            $dispatching = Dispatching::findOrFail($id);
            $dispatching->no_transaksi = $request->no_transaksi;
            $dispatching->tanggal = $request->tanggal;

            if ($request->hasFile('file_bukti')) {
                $filePath = $request->file('file_bukti')->store('bukti-barang-keluar');
                $dispatching->file = $filePath;
            }

            $dispatching->save();

            // Ambil semua data pivot yang lama
            $oldPivots = Pivot_dispatching::where('dispatching_transaksi', $dispatching->no_transaksi)->get();

            // Menambah stok item sesuai dengan jumlah pada pivot yang lama
            foreach ($oldPivots as $oldPivot) {
                $item = Item::where('sku', $oldPivot->item_sku)->first();
                if ($item) {
                    $item->stok += $oldPivot->jumlah;
                    $item->save();
                }
            }

            // Hapus data pivot yang lama
            Pivot_dispatching::where('dispatching_transaksi', $dispatching->no_transaksi)->delete();

            // Tambahkan data pivot yang baru dan update stok item
            foreach ($request->sku as $key => $sku) {
                $item = Item::where('sku', $sku)->first();

                Pivot_dispatching::create([
                    'dispatching_transaksi' => $dispatching->no_transaksi,
                    'item_sku' => $sku,
                    'jumlah' => $request->jumlah[$key],
                ]);

                // Update stok item
                if ($item) {
                    $item->stok -= $request->jumlah[$key];
                    $item->save();
                }
            }

            // Commit transaksi database
            DB::commit();
            Alert::toast('Barang Keluar Diupdate','success');
            return redirect('dispatching');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dispatching $dispatching)
    {
        if($dispatching->file){
            Storage::delete($dispatching->file);
        }

        $oldPivots = Pivot_dispatching::where('dispatching_transaksi', $dispatching->no_transaksi)->get();

        foreach ($oldPivots as $oldPivot) {
                $item = Item::where('sku', $oldPivot->item_sku)->first();
                if ($item) {
                    $item->stok += $oldPivot->jumlah;
                    $item->save();
                }
            }

        dispatching::destroy($dispatching->id);
        Alert::toast('Barang Terhapus','success');
        return redirect('dispatching');
    }
}
