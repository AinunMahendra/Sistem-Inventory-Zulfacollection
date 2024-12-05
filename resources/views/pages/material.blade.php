<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="Material"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Material"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3">Tabel Material</h6>
                                <button type="button" id="tambahBtn" class="btn btn-success ms-auto me-3"
                                    data-bs-toggle="modal" data-bs-target="#modal-form">Tambah Material +</button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="ms-md-10 pe-md-10 d-flex align-items-center">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">ketik Disini ...</label>
                                    <input type="text" class="form-control" id="searchInput">
                                </div>
                            </div>
                            <div class="table-responsive p-1">
                                {{-- Tabel Data --}}
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th>
                                            <th
                                                class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kode Material</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                                Nama Material</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Stok</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                            {{-- <th class="text-secondary opacity-7"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="itemTableBody">
                                        {{-- Looping Data --}}
                                        @foreach ($items as $item)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">{{ $loop->iteration }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm" >
                                                    <h6 class="mb-0 text-sm">{{ $item->sku }}</h6>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        @if ($item->gambar)
                                                            <div>
                                                                <img src="{{ asset('storage') . '/' . $item->gambar }}"
                                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                                    alt="user1">
                                                            </div>
                                                        @else
                                                            <div>
                                                                <img src="{{ asset('assets') }}/img/team-2.jpg"
                                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                                    alt="user1">
                                                            </div>
                                                        @endif
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                                                            <p class="text-xs font-weight-bold mb-0">{{ $item->jenis }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if ($item->stok == 0)
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="badge badge-sm bg-gradient-danger">Habis</span>
                                                    </td>
                                                @elseif ($item->stok <= 3)
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="badge badge-sm bg-gradient-warning">Menipis</span>
                                                    </td>
                                                @elseif ($item->stok > 3)
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="badge badge-sm bg-gradient-success">Ada</span>
                                                    </td>
                                                @endif

                                                <td class="  text-center">
                                                    <h6 class="mb-0 text-sm">{{ $item->stok }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-success editBtn "
                                                            data-bs-toggle="modal" data-bs-target="#modal-form"
                                                            data-item='{{ json_encode($item) }}' data-operation="edit">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <a href="#" class="btn btn-secondary btn-link archive"
                                                            data-item-id="{{ $item->id }}">
                                                            <i class="material-icons">archive</i>
                                                        </a>
                                                        <form id="archive-form" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
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
        {{-- Modal Form --}}
        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 60vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title font-weight-normal" id="modal-title-default"></h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span class="material-icons" aria-hidden="true">close</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-body">
                                <form role="form text-left" id="dataForm" action="material" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="id" class="form-control">
                                    <div class="input-group input-group-static my-2">
                                        <label>Kode Material</label>
                                        <input type="text" name="sku" id="sku" class="form-control"
                                            onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    </div>
                                    <div class="input-group input-group-static my-2">
                                        <label>Nama Material</label>
                                        <input type="text" name="nama" id="nama" class="form-control"
                                            onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    </div>
                                    <div class="input-group input-group-static my-2">
                                        <label>Tipe</label>
                                        <input type="text" name="jenis" id="jenis" class="form-control"
                                            onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    </div>
                                    <div class="input-group input-group-static my-2">
                                        <label id="label-stok">Stok</label>
                                        <input type="hidden" name="stok" id="stok" class="form-control"
                                            onfocus="focused(this)" onfocusout="defocused(this)" value="10" required>
                                    </div>
                                    <div class="input-group input-group-static my-2">
                                        <label>Input Gambar</label>
                                        <input class="form-control" name="gambar" type="file" id="image"
                                            onchange="previewImage()">
                                    </div>
                                    <input type="hidden" name="material" id="material" value="true">
                                    <input type="hidden" name="archive" id="archive" value="false">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-preview img-fluid mb-2 col-sm-5">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="simpanBtn"
                                            class="btn btn-round bg-gradient-success btn-lg w-100 mt-4 mb-0"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Script Tambah dan Edit Barang --}}
        <script>
            $(document).ready(function() {
                // Menampilkan modal untuk mengedit data
                $('.editBtn').click(function() {
                    var item = $(this).data('item');
                    var operation = $(this).data('operation'); // Mengambil operasi dari data HTML
                    $("#modal-title-default").html('Edit Material')
                    $("#simpanBtn").html('UPDATE')
                    $('#stok').prop('type', 'text');
                    $('#label-stok').show();

                    // Menetapkan nilai kode ke dalam form
                    $('#id').val(item.id);
                    $('#sku').val(item.sku);
                    $('#nama').val(item.nama);
                    $('#jenis').val(item.jenis);
                    $('#stok').val(item.stok);

                    if (item.gambar) {
                        $('.img-preview').show();
                        $('.img-preview').attr('src', "{{ asset('storage/') }}" + "/" + item.gambar);
                    } else {
                        // Jika tidak ada gambar, sembunyikan pratinjau gambar dan tampilkan input file
                        $('.img-preview').hide(); // Sembunyikan pratinjau gambar
                    }

                    // Menampilkan modal form
                    $('#modal-form').modal('show');
                });

                //Tombol untuk menambah data baru
                $('#tambahBtn').click(function() {
                    $("#modal-title-default").html('Tambahkan Barang Disini')
                    $("#simpanBtn").html('TAMBAHKAN')
                    $('#label-stok').hide();
                    $('#stok').prop('type', 'hidden');

                    // Bersihkan nilai form
                    $('#id').val(null);
                    $('#sku').val(null);
                    $('#nama').val(null);
                    $('#jenis').val(null);
                    $('#stok').val(null);


                    // Menampilkan modal form
                    $('#modal-form').modal('show');
                    $('.img-preview').hide();
                });
            });

            function previewImage() {
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');

                imgPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }
        </script>
        {{-- Script Select 2 --}}
        <script type="text/javascript">
            $(function() {
                $(document).on('click', '.archive', function(e) {
                    e.preventDefault();
                    var itemId = $(this).data('item-id');
                    var form = $('#archive-form');
                    var actionUrl = '{{ url('material') }}/' + itemId;

                    Swal.fire({
                        title: "Yakin Mau Di Arsip in nih?",
                        text: "Nanti Data Barang ini Masuk di Halaman Archive",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yakin",
                        cancelButtonText: "Gak Jadi"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.attr('action', actionUrl);
                            form.submit();

                            Swal.fire({
                                title: "Archived",
                                text: "Data Udah Masuk Di Archive",
                                icon: "success"
                            });
                        }
                    });
                });
            });
        </script>
        {{-- Script Search --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var query = $(this).val();

                    $.ajax({
                        url: "{{ route('search.material') }}",
                        type: "GET",
                        data: {
                            'search': query
                        },
                        success: function(data) {
                            $('#itemTableBody').html(data);
                        }
                    });
                });
            });
        </script>

    </main>
    <x-plugins></x-plugins>
</x-layout>
