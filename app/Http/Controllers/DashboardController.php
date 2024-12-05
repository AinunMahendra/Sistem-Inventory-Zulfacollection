<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Receiving;
use App\Models\Dispatching;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $jumlahItem = Item::where('material', false)->count();
        $jumlahItemArsip = Item::where('material', false)->where('archive', true)->count();
        $jumlahMaterial = Item::where('material', true)->count();
        $jumlahMaterialArsip = Item::where('material', true)->where('archive', true)->count();
        $jumlahReceiving = Receiving::count();
        $jumlahReceivingBulanIni = Receiving::whereMonth('tanggal', $currentMonth)
                           ->whereYear('tanggal', $currentYear)
                           ->count();

        $jumlahDispatching = Dispatching::count();
        $jumlahDispatchingBulanIni = Dispatching::whereMonth('tanggal', $currentMonth)
                           ->whereYear('tanggal', $currentYear)
                           ->count();

        $itemHabis = Item::where('material', false)->where('stok','=', 0)->get();
        $jumlahItemHabis = $itemHabis->count();

        $dispatchings = Dispatching::with('Pivot_dispatchings.item')->orderBy('created_at', 'desc')->take(6)->get();


        // dd($dispatchings);
        return view('dashboard.index',  compact('jumlahItem', 'jumlahItemArsip','jumlahMaterial', 'jumlahMaterialArsip','jumlahReceivingBulanIni', 'jumlahReceiving','jumlahDispatchingBulanIni', 'jumlahDispatching', 'jumlahItemHabis' , 'itemHabis', 'dispatchings'));
    }
}
