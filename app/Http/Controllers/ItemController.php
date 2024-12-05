<?php

namespace App\Http\Controllers;

use Alert;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Lotforlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getCurrentPeriod() {
        $month = date('m');

        if ($month == 1 || $month == 2) {
            return 'jan_feb';
        } elseif ($month == 3 || $month == 4) {
            return 'mar_apr';
        } elseif ($month == 5 || $month == 6) {
            return 'mei_jun';
        } elseif ($month == 7 || $month == 8) {
            return 'jul_agt';
        } elseif ($month == 9 || $month == 10) {
            return 'sep_okt';
        } else {
            return 'nov_des';
        }
    }
    public function index()
    {
        return view('pages.tables', [
            'items' => Item::where('material', false)->where('archive', false)->paginate(20),
        ]);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('search');
            $items = Item::where('material', false)
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
        return redirect('barang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Item $item)
    {
        $rules =[
            'id'=>'nullable',
            'nama'=>'required|max:100',
            'jenis'=>'required|max:100',
            'warna'=>'required',
            'ukuran'=>'required',
            'gambar'=>'nullable|image|file|max:5000',
            'stok'=> 'required',
            'material'=> 'required|in:true,false',
            'archive'=> 'required|in:true,false',

        ];

        $data = $request->except('_token'); //Mengambil data tanpa _token

        if ($request->filled('id')) { //ketika $request mempunyai id atau Fungsi Edit

            $item = Item::where('id', $request->id)->first();
            if($request->sku != $item->sku) {
                $rules['sku'] ='required|max:100|unique:Items';
            }
            $data = $request->validate($rules);
            if($request->file('gambar')) { //pengambilan Gambar
                if($item->gambar != null){
                    Storage::delete($item->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('gambar-produk');
            }
            $data['material'] = filter_var($request->material, FILTER_VALIDATE_BOOLEAN);
            $data['archive'] = filter_var($request->archive, FILTER_VALIDATE_BOOLEAN);
            Item::where('id', '=', $request->id)->update($data);
            Alert::toast('Barang Terupdate','success');
            return redirect('barang');

        }else{  //ketika $request tidak mempunyai id atau Fungsi Tambah Data

            $rules['sku'] ='required|max:100|unique:Items';
            $data = $request->validate($rules);
            if($request->file('gambar')) { //pengambilan Gambar
                $data['gambar'] = $request->file('gambar')->store('gambar-produk');
            }
            unset($data['id']); // Menghilangkan kolom ID
            $data['material'] = filter_var($request->material, FILTER_VALIDATE_BOOLEAN);
            $data['archive'] = filter_var($request->archive, FILTER_VALIDATE_BOOLEAN);
            // dd($data);
            Item::create($data);
            Alert::toast('Barang Ditambahkan','success');
            return redirect('barang');
        }
    }

    public function lotforlot(String $itemName)
    {
        $lotforlot = LotForLot::whereHas('item', function($query) use ($itemName) {
            $query->where('nama', $itemName);
        })->with('item')->get();

        // Sort by size
        $sortedLotforlot = $lotforlot->sortBy(function($lot) {
            return $this->getSizeOrder($lot->item->ukuran);
        });

        $currentPeriod = $this->getCurrentPeriod();

        return view('pages.lot-for-lot', ['lotforlot' => $sortedLotforlot, 'currentPeriod' => $currentPeriod]);
    }

    private function getSizeOrder($size)
    {
        $order = ['S' => 1, 'M' => 2, 'L' => 3, 'XL' => 4];
        return $order[$size] ?? 999; // Return a high number if size is not in the order
    }

    public function forecasting(Request $request)
    {
        // Ambil semua parameter dari request
        $data = $request->all();

        // Inisialisasi array untuk simpan hasil rata-rata
        $averages = [];

        // Loop untuk setiap index (0, 1, 2, 3)
        for ($i = 0; $i < 4; $i++) {
            // Ambil nilai dari tiap bulan untuk index $i
            $values = [
                $data['1bulan'][$i],
                $data['2bulan'][$i],
                $data['3bulan'][$i],
                $data['4bulan'][$i]
            ];

            // Hitung rata-rata
            $average = array_sum($values) / count($values);

            // Bulatkan hasil rata-rata
            $roundedAverage = (int) round($average);

            // Simpan hasil rata-rata yang dibulatkan ke array averages
            $averages[] = $roundedAverage;
        }

        // Ambil bulan sekarang
        $currentMonth = Carbon::now()->format('m');

        // Tentukan kolom yang akan diupdate berdasarkan bulan sekarang
        $periodColumn = $this->getPeriodColumn($currentMonth);

        $skus = $request->input('sku');
        foreach ($skus as $index => $sku) {
            $lotforlot = LotForLot::where('item_sku', $sku)->first();

            if ($lotforlot) {
                $lotforlot->update([
                    $periodColumn => $averages[$index],
                ]);
            }
        }

        $item = Item::where('sku', $skus[1])->first();

        // Dump hasil rata-rata buat dicek
        Alert::toast('Lot Berhasil di Ubah','success');
        return redirect()->route('l4l', ['item' => $item->nama]);
    }

    private function getPeriodColumn($month)
    {
        // Map bulan ke nama kolom dua bulanan
        $columns = [
            '01' => 'jan_feb',
            '02' => 'jan_feb',
            '03' => 'mar_apr',
            '04' => 'mar_apr',
            '05' => 'mei_jun',
            '06' => 'mei_jun',
            '07' => 'jul_agt',
            '08' => 'jul_agt',
            '09' => 'sep_okt',
            '10' => 'sep_okt',
            '11' => 'nov_des',
            '12' => 'nov_des',
        ];

        // Kembalikan nama kolom berdasarkan bulan sekarang
        return $columns[$month] ?? 'unknown_period';
    }

    public function lotforlotStore(Request $request)
    {

        $rules = [
            'sku.*' => 'nullable',
            'jan_feb.*' => 'required|integer',
            'mar_apr.*' => 'required|integer',
            'mei_jun.*' => 'required|integer',
            'jul_agt.*' => 'required|integer',
            'sep_okt.*' => 'required|integer',
            'nov_des.*' => 'required|integer',
        ];


        $validatedData = $request->validate($rules);

        $skus = $request->input('sku');
        $janFebs = $request->input('jan_feb');
        $marAprs = $request->input('mar_apr');
        $meiJuns = $request->input('mei_jun');
        $julAgts = $request->input('jul_agt');
        $sepOkts = $request->input('sep_okt');
        $novDess = $request->input('nov_des');

        foreach ($skus as $index => $sku) {
            $lotforlot = LotForLot::where('item_sku', $sku);

        if ($lotforlot) {
                $lotforlot->update([
                'jan_feb' => $janFebs[$index],
                'mar_apr' => $marAprs[$index],
                'mei_jun' => $meiJuns[$index],
                'jul_agt' => $julAgts[$index],
                'sep_okt' => $sepOkts[$index],
                'nov_des' => $novDess[$index],
                ]);
            }
        }

        $item = Item::where('sku', $skus[1])->first();
        // dd($item);

        Alert::toast('Lot Berhasil di Ubah','success');
        return redirect()->route('l4l', ['item' => $item->nama]);

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
    // public function destroy(Item $item)
    // {

    //     $item->update(['archive' => true]); // Misalkan Anda punya kolom 'archived'

    //     Alert::toast('Barang Ditambahkan Ke Archive','success');
    //     return redirect('barang');
    // }
}
