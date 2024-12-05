<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="New User" beforePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Tambahkan User</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form method='POST' action='{{ route('edit.user', ['id' => $data->id]) }}'>
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2"
                                            value="{{ $data->name }}">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control border border-2 p-2"
                                            value="{{ $data->email }}">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">No HP</label>
                                        <input type="text" name="phone" class="form-control border border-2 p-2"
                                            value="{{ $data->phone }}">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Role</label>
                                        <select name="is_admin" class="form-select border border-2 p-2"
                                            value="{{ $data->is_admin }}">
                                            <option value="true">Super Admin</option>
                                            <option value="false">Admin</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="location" class="form-control border border-2 p-2"
                                            value="{{ $data->location }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control border border-2 p-2">
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
</x-layout>
