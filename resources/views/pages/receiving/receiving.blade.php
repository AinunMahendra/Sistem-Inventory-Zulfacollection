<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="Receivings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Receivings"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3">Tabel Barang Masuk</h6>
                                <div class="me-3 my-1 text-end">
                                    <a class="btn bg-gradient-dark" href="{{ route('new-receiving') }}">
                                        <i class="material-icons text-sm">add</i>
                                        Barang Masuk
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-1">
                                {{-- Tabel Data --}}
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No Transaksi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Informasi Barang</th>
                                            <th
                                                class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                                Tanggal Masuk</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jumlah Total Barang</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                            {{-- <th class="text-secondary opacity-7"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Looping Data --}}
                                        @foreach ($receivings as $receiving)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">{{ $receiving->no_transaksi }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">
                                                        @php
                                                            // Mengelompokkan item berdasarkan jenis dan menghitung jumlah entri untuk setiap jenis
                                                            $itemDetails = [];
                                                            foreach ($receiving->Pivot_receivings as $pivot) {
                                                                $jenis = $pivot->item->jenis;
                                                                if (isset($itemDetails[$jenis])) {
                                                                    $itemDetails[$jenis]++;
                                                                } else {
                                                                    $itemDetails[$jenis] = 1;
                                                                }
                                                            }
                                                        @endphp
                                                        {{-- menampilkan jumlah jenis yang di inputkan --}}
                                                        @foreach ($itemDetails as $jenis => $count)
                                                            {{ $count }} {{ $jenis }}<br>
                                                        @endforeach
                                                    </h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">{{ $receiving->tanggal }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @php
                                                        // Hitung total jumlah item yang diinputkan dalam satu transaksi
                                                        $totalJumlah = $receiving->Pivot_receivings->sum('jumlah');
                                                    @endphp
                                                    <h6 class="mb-0 text-sm">{{ $totalJumlah }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="mt-2">
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="receiving/edit-receiving/ {{ $receiving->id }}"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <a href="{{ route('delete.receiving', $receiving->id) }}"
                                                            class="btn btn-danger btn-link"
                                                            data-confirm-delete="true"><i
                                                                class="material-icons">close</i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pagination --}}
            {{-- {{ $items->links('pages.pagination.default') }} --}}
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
