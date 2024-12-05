<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Receiving;
use App\Models\Pivot_receiving;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Delete Data!';
        $text = "Apa beneran mau hapus data ini?";
        confirmDelete($title, $text);

        $receivings = Receiving::with('Pivot_receivings.item')->paginate(7);

        return view('pages.receiving.receiving',[
            'receivings' =>$receivings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.receiving.new-receiving');
    }

    public function pilihbarang()
    {
        $data = Item::where('nama', 'LIKE', '%'.request('q').'%')->paginate(10);
        return response()->json($data);
    }

    public function pilihsku()
    {
        $data = Item::where('sku', 'LIKE', '%'.request('q').'%')->paginate(10);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =[
            'no_transaksi' => 'required|max:100|unique:Receivings',
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
                $data['file_bukti'] = $request->file('file_bukti')->store('bukti-barang-masuk');
            }

       $receivingData = [
        'no_transaksi' => $data['no_transaksi'],
        'tanggal' => $data['tanggal'],
        ];

        if (isset($data['file_bukti'])) {
        $receivingData['file'] = $data['file_bukti'];
        }

        Receiving::create($receivingData);

        foreach ($data ['sku'] as $key => $sku) {
            Pivot_receiving::create([
                'receiving_transaksi' => $data['no_transaksi'],
                'item_sku' => $sku,
                'jumlah' => $data['jumlah'][$key],
            ]);

            $item = Item::where('sku', $sku)->first();
            // dd($item);
            if ($item) {
            $item->stok += $data['jumlah'][$key];
            $item->save();
            }
        }

        Alert::toast('Barang Masuk Ditambahkan','success');
        return redirect('receiving');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Receiving = Receiving::with('Pivot_receivings.item')->findOrFail($id);

        return view('pages.receiving.edit-receiving', compact('Receiving'));
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
            // Update data pada tabel `receiving`
            $receiving = Receiving::findOrFail($id);
            $receiving->no_transaksi = $request->no_transaksi;
            $receiving->tanggal = $request->tanggal;

            if ($request->hasFile('file_bukti')) {
                $filePath = $request->file('file_bukti')->store('bukti-barang-masuk');
                $receiving->file = $filePath;
            }

            $receiving->save();

            // Ambil semua data pivot yang lama
            $oldPivots = Pivot_receiving::where('receiving_transaksi', $receiving->no_transaksi)->get();

            // Kurangi stok item sesuai dengan jumlah pada pivot yang lama
            foreach ($oldPivots as $oldPivot) {
                $item = Item::where('sku', $oldPivot->item_sku)->first();
                if ($item) {
                    $item->stok -= $oldPivot->jumlah;
                    $item->save();
                }
            }

            // Hapus data pivot yang lama
            Pivot_receiving::where('receiving_transaksi', $receiving->no_transaksi)->delete();

            // Tambahkan data pivot yang baru dan update stok item
            foreach ($request->sku as $key => $sku) {
                $item = Item::where('sku', $sku)->first();

                Pivot_receiving::create([
                    'receiving_transaksi' => $receiving->no_transaksi,
                    'item_sku' => $sku,
                    'jumlah' => $request->jumlah[$key],
                ]);

                // Update stok item
                if ($item) {
                    $item->stok += $request->jumlah[$key];
                    $item->save();
                }
            }

            // Commit transaksi database
            DB::commit();
            Alert::toast('Barang Masuk Diupdate','success');
            return redirect('receiving');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receiving $receiving)
    {
        if($receiving->file){
            Storage::delete($receiving->file);
        }

        $oldPivots = Pivot_receiving::where('receiving_transaksi', $receiving->no_transaksi)->get();

        foreach ($oldPivots as $oldPivot) {
                $item = Item::where('sku', $oldPivot->item_sku)->first();
                if ($item) {
                    $item->stok -= $oldPivot->jumlah;
                    $item->save();
                }
            }

        receiving::destroy($receiving->id);
        Alert::toast('Barang Terhapus','success');
        return redirect('receiving');
    }
}
