<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="Barang"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Lot For Lot" beforePage="Barang"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3">{{ $lotforlot[0]->item->nama }} Warna
                                    {{ $lotforlot[0]->item->warna }}</h6>
                                <button type="button" class="btn btn-success ms-auto me-3" data-bs-toggle="modal"
                                    data-bs-target="#modal-form1">Peramalan Lot</button>
                                <button type="button" id="editBtn" class="btn btn-success ms-auto me-3"
                                    data-bs-toggle="modal" data-bs-target="#modal-form">Atur Kebutuhan Periode</button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-4">
                                {{-- Tabel Data --}}
                                @foreach ($lotforlot as $l4l)
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-info text-xl font-weight-bolder opacity-7">
                                                    Ukuran : {{ $l4l->item->ukuran }}</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jan-Feb</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Mar-Apr</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Mei-Jun</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jul-Agt</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Sep-Okt</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nov-Des</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-3">
                                                    Kebutuhan</td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->jan_feb }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->mar_apr }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->mei_jun }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->jul_agt }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->sep_okt }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm py-3">
                                                    <h6 class="mb-0 text-sm">{{ $l4l->nov_des }}</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-3">
                                                    Persediaan Gudang</td>
                                                @php
                                                    $bulanSekarang = now()->format('n'); // Ambil bulan sekarang dalam bentuk angka (1-12)
                                                    $stokTerakhir = $l4l->item->stok; // Stok awal dari database
                                                    $stokBulanLalu = $stokTerakhir; // Inisialisasi stok bulan lalu
                                                @endphp
                                                @for ($i = 1; $i <= 12; $i += 2)
                                                    <!-- Loop untuk setiap dua bulan -->
                                                    <td class="align-middle text-center text-sm py-3">
                                                        @if ($i <= $bulanSekarang)
                                                            <!-- Bulan sudah lewat atau bulan ini -->
                                                            @php
                                                                if ($i == $bulanSekarang) {
                                                                    $stokTersedia = $stokBulanLalu + $l4l->item->masuk; // Update stok terakhir dengan barang masuk
                                                                    $stokTerakhir = $stokTersedia;
                                                                } else {
                                                                    $stokTersedia = $stokTerakhir;
                                                                }
                                                            @endphp
                                                            <h6 class="mb-0 text-sm">{{ $stokTersedia }}</h6>
                                                        @else
                                                            <!-- Bulan belum tiba, kosongin aja -->
                                                            <span class="badge bg-info">
                                                                <i class="material-icons">timer</i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    @php
                                                        // Update stok bulan lalu
                                                        $stokBulanLalu = $stokTersedia;
                                                    @endphp
                                                @endfor
                                            </tr>
                                            <tr>
                                                <td
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-3">
                                                    Rencana Produksi</td>
                                                @php
                                                    $bulanSekarang = now()->format('n'); // Ambil bulan sekarang dalam bentuk angka (1-12)
                                                    $stokBulanLalu = $l4l->item->stok; // Stok awal untuk bulan sebelumnya
                                                @endphp
                                                @for ($i = 1; $i <= 12; $i += 2)
                                                    <!-- Loop untuk setiap dua bulan -->
                                                    @php
                                                        // Rencana produksi dihitung dengan Kebutuhan Bersih bulan ini dikurangi Persediaan Gudang bulan lalu
                                                        if ($i <= $bulanSekarang) {
                                                            if ($i == 1) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->jan_feb - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            } elseif ($i == 3) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->mar_apr - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            } elseif ($i == 5) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->mei_jun - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            } elseif ($i == 7) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->jul_agt - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            } elseif ($i == 9) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->sep_okt - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            } elseif ($i == 11) {
                                                                $rencanaProduksi = max(
                                                                    $l4l->nov_des - $stokBulanLalu,
                                                                    0,
                                                                );
                                                            }
                                                        } else {
                                                            $rencanaProduksi = 0;
                                                        }
                                                    @endphp
                                                    <td class="align-middle text-center text-sm py-3">
                                                        @if ($i <= $bulanSekarang)
                                                            <!-- Bulan sudah lewat atau bulan ini -->
                                                            <h6 class="mb-0 text-sm">{{ $rencanaProduksi }}</h6>
                                                        @else
                                                            <!-- Bulan belum tiba, kosongin aja -->
                                                            <span class="badge bg-info">
                                                                <i class="material-icons">timer</i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    @php
                                                        // Update stok bulan lalu
                                                        if ($i == $bulanSekarang) {
                                                            $stokBulanLalu = $l4l->item->stok;
                                                        } else {
                                                            $stokBulanLalu = $stokTersedia;
                                                        }
                                                    @endphp
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>

        {{-- Modal Form Kebutuhan Lot --}}
        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 60vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title font-weight-normal"> {{ $lotforlot[0]->item->nama }} Warna
                            {{ $lotforlot[0]->item->warna }} </h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span class="material-icons" aria-hidden="true">close</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-body">

                                <form action="{{ route('l4l.input') }}" method="POST">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    @foreach ($lotforlot as $l4l)
                                        <input type="hidden" name="sku[]" id="sku" class="form-control"
                                            value="{{ $l4l->item_sku }}">
                                        <h6 class="modal-title font-weight-bold"> Ukuran : {{ $l4l->item->ukuran }}
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Jan-Feb</label>
                                                    <input type="number" name="jan_feb[]" id="jan-feb"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->jan_feb }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Mar-Apr</label>
                                                    <input type="number" name="mar_apr[]" id="mar-apr"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->mar_apr }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Mei-Jun</label>
                                                    <input type="number" name="mei_jun[]" id="mei-jun"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->mei_jun }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Jul-Agt</label>
                                                    <input type="number" name="jul_agt[]" id="jul-agt"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->jul_agt }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Sep-Okt</label>
                                                    <input type="number" name="sep_okt[]" id="sep-okt"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->sep_okt }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-2">
                                                    <label>Nov-Des</label>
                                                    <input type="number" name="nov_des[]" id="nov-des"
                                                        class="form-control" onfocus="focused(this)"
                                                        onfocusout="defocused(this)" value="{{ $l4l->nov_des }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center">
                                        <button type="submit" id="simpanBtn"
                                            class="btn btn-round bg-gradient-success btn-lg w-100 mt-4 mb-0">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Peramalan --}}
        <div class="modal fade" id="modal-form1" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 60vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title font-weight-normal">{{ $lotforlot[0]->item->nama }} Warna
                            {{ $lotforlot[0]->item->warna }}</h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="material-icons" aria-hidden="true">close</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="card card-plain">
                            <h6 class="font-weight-normal text-warning m-2">
                                *Masukan Penjualan Bulan Lalu untuk Melakukan Peramalan di Periode Sekarang
                            </h6>
                            <h6 class="font-weight-normal text-sm text-warning m-2 mt-0">
                                Hindari periode bulan Rhamadan
                            </h6>
                            <div class="card-body p-2">
                                <form action="{{ route('forecasting') }}" method="POST">
                                    @csrf
                                    @foreach ($lotforlot as $l4l)
                                        <input type="hidden" name="sku[]" id="sku" class="form-control"
                                            value="{{ $l4l->item_sku }}">
                                        <h6 class="modal-title font-weight-bold mb-2">Ukuran: {{ $l4l->item->ukuran }}
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-6 col-md-3">
                                                <div class="input-group input-group-static my-1">
                                                    <label>4 bulan lalu</label>
                                                    <input type="number" name="4bulan[]" class="form-control"
                                                        style="width: 100%;" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="input-group input-group-static my-1">
                                                    <label>3 bulan lalu</label>
                                                    <input type="number" name="3bulan[]" class="form-control"
                                                        style="width: 100%;" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="input-group input-group-static my-1">
                                                    <label>2 bulan lalu</label>
                                                    <input type="number" name="2bulan[]" class="form-control"
                                                        style="width: 100%;" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="input-group input-group-static my-1">
                                                    <label>1 bulan lalu</label>
                                                    <input type="number" name="1bulan[]" class="form-control"
                                                        style="width: 100%;" onfocus="focused(this)"
                                                        onfocusout="defocused(this)">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center">
                                        <button type="submit" id="simpanBtn"
                                            class="btn btn-round bg-gradient-success btn-lg w-50 mt-3 mb-0">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
