<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="Receivings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Input Receiving" beforePage="Receivings"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Input Daftar Barang Masuk</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form method='POST' action='{{ route('input.receiving') }}' enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-center">No Transaksi</label>
                                        <input type="text" name="no_transaksi"
                                            class="form-control border border-2 p-2 text-center" required>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-3">
                                        <label class="form-label text-center">SKU</label>
                                        <select class="form-control form-select-lg" style="width: 150%" id="sku"
                                            name="sku[]"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-center">Barang</label>
                                        <select class="form-control" style="width: 150%" id="barang"
                                            name="nama_barang[]"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-center">Jumlah</label>
                                        <input type="number" name="jumlah[]" style="height: 30px"
                                            class="form-control border border-2 p-2" max="999" step="1" required>
                                    </div>
                                </div>
                                <div id="inputContainer">
                                    <!-- Initial input fields -->
                                    <!-- No additional inputs added here -->
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
                                        <input type="date" name="tanggal" class="form-control border border-2 p-2" required>
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
            // Inisialisasi select2 untuk SKU dan Barang pada input pertama
            $("#sku").select2({
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

            $("#barang").select2({
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

            // Script untuk menambahkan field input saat tombol tambah ditekan
            const tambahInput = document.getElementById('tambahInput');
            tambahInput.addEventListener('click', function() {
                const inputContainer = document.getElementById('inputContainer');

                // Membuat elemen baru untuk baris input tambahan
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'justify-content-between');

                // Kolom SKU
                const skuCol = document.createElement('div');
                skuCol.classList.add('col-md-3');

                const labelSku = document.createElement('label');
                labelSku.classList.add('form-label', 'text-center');
                labelSku.textContent = 'SKU';
                const selectSku = document.createElement('select');
                selectSku.setAttribute('name', 'sku[]');
                selectSku.classList.add('form-control', 'form-select-lg');
                selectSku.style.width = '150%'; // Ubah lebar select
                skuCol.appendChild(labelSku);
                skuCol.appendChild(selectSku);

                // Kolom Barang
                const barangCol = document.createElement('div');
                barangCol.classList.add('col-md-3');

                const labelBarang = document.createElement('label');
                labelBarang.classList.add('form-label', 'text-center');
                labelBarang.textContent = 'Barang';
                const selectBarang = document.createElement('select');
                selectBarang.setAttribute('name', 'nama_barang[]');
                selectBarang.classList.add('form-control');
                selectBarang.style.width = '150%'; // Ubah lebar select
                barangCol.appendChild(labelBarang);
                barangCol.appendChild(selectBarang);

                // Kolom Jumlah
                const jumlahCol = document.createElement('div');
                jumlahCol.classList.add('col-md-3');

                const labelJumlah = document.createElement('label');
                labelJumlah.classList.add('form-label', 'text-center');
                labelJumlah.textContent = 'Jumlah';
                const inputJumlah = document.createElement('input');
                inputJumlah.setAttribute('type', 'number');
                inputJumlah.setAttribute('name', 'jumlah[]');
                inputJumlah.classList.add('form-control', 'border', 'border-2', 'p-2');
                inputJumlah.style.height = '30px'; // Ubah tinggi input
                jumlahCol.appendChild(labelJumlah);
                jumlahCol.appendChild(inputJumlah);

                // Menyalin nilai dari input pertama ke input yang baru ditambahkan
                const firstSKU = document.querySelector('[name="sku[]"]');
                const firstBarang = document.querySelector('[name="nama_barang[]"]');
                const firstJumlah = document.querySelector('[name="jumlah[]"]');
                selectSku.innerHTML = firstSKU.innerHTML;
                selectBarang.innerHTML = firstBarang.innerHTML;
                inputJumlah.value = firstJumlah.value;

                // Menambahkan kolom SKU, Barang, dan Jumlah ke dalam baris baru
                newRow.appendChild(skuCol);
                newRow.appendChild(barangCol);
                newRow.appendChild(jumlahCol);

                // Menambahkan baris baru ke dalam container input
                inputContainer.appendChild(newRow);

                // Inisialisasi select2 untuk sku dan barang
                $(selectSku).select2({
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

                $(selectBarang).select2({
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
            });
        });
    </script>
</x-layout>
