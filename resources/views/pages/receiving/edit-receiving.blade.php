<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="Receivings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Receiving" beforePage="Receivings"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Edit Daftar Barang Masuk</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form method='POST' action='{{ route('update.receiving', ['id' => $Receiving->id]) }}' enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-center">No Transaksi</label>
                                        <input type="text" name="no_transaksi" value="{{ $Receiving->no_transaksi }}"
                                            class="form-control border border-2 p-2 text-center">
                                    </div>
                                </div>
                                <div id="inputContainer">
                                    @foreach ($Receiving->Pivot_receivings as $pivot)
                                        <div class="row justify-content-between mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label text-center">SKU</label>
                                                <select name="sku[]" class="form-control form-select-lg select2-sku"
                                                    style="width: 150%">
                                                    <option value="{{ $pivot->item_sku }}" selected>
                                                        {{ $pivot->item->sku }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-center">Barang</label>
                                                <select name="nama_barang[]" class="form-control select2-barang"
                                                    style="width: 150%">
                                                    <option value="{{ $pivot->item->id }}" selected>
                                                        {{ $pivot->item->nama }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-center">Jumlah</label>
                                                <input type="number" name="jumlah[]"
                                                    class="form-control border border-2 p-2" style="height: 30px"
                                                    value="{{ $pivot->jumlah }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12 d-flex justify-content-center mt-4">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            id="tambahInput">Tambah</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control border border-2 p-2" value="{{ $Receiving->tanggal }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">File Bukti</label>
                                        <input type="file" name="file_bukti"
                                            class="form-control border border-2 p-2">
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-gradient-dark">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    <script>
        $(document).ready(function() {
            // Fungsi untuk inisialisasi select2 pada elemen SKU
            function initializeSelect2SKU(element) {
                $(element).select2({
                    theme: "classic",
                    placeholder: 'Pilih SKU',
                    ajax: {
                        url: "{{ route('pilih.sku') }}",
                        processResults: function({
                            data
                        }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.sku,
                                        text: item.sku
                                    }
                                })
                            }
                        }
                    }
                });
            }

            // Fungsi untuk inisialisasi select2 pada elemen Barang
            function initializeSelect2Barang(element) {
                $(element).select2({
                    placeholder: 'Pilih Barang',
                    ajax: {
                        url: "{{ route('pilih.barang') }}",
                        processResults: function({
                            data
                        }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.nama
                                    }
                                })
                            }
                        }
                    }
                });
            }

            // Inisialisasi select2 untuk semua elemen select yang sudah ada
            $('.select2-sku').each(function() {
                initializeSelect2SKU(this);
            });

            $('.select2-barang').each(function() {
                initializeSelect2Barang(this);
            });

            // Script untuk menambahkan field input saat tombol tambah ditekan
            $('#tambahInput').on('click', function() {
                const inputContainer = $('#inputContainer');

                // Membuat elemen baru untuk baris input tambahan
                const newRow = $(`
                <div class="row justify-content-between mb-2">
                    <div class="col-md-3">
                        <label class="form-label text-center">SKU</label>
                        <select name="sku[]" class="form-control form-select-lg select2-sku" style="width: 150%"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-center">Barang</label>
                        <select name="nama_barang[]" class="form-control select2-barang" style="width: 150%"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-center">Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control border border-2 p-2" style="height: 30px">
                    </div>
                </div>
            `);

                // Menambahkan baris baru ke dalam container input
                inputContainer.append(newRow);

                // Inisialisasi select2 untuk elemen select yang baru ditambahkan
                newRow.find('.select2-sku').each(function() {
                    initializeSelect2SKU(this);
                });

                newRow.find('.select2-barang').each(function() {
                    initializeSelect2Barang(this);
                });
            });
        });
    </script>
</x-layout>
