<!-- Menghubungkan dengan view template cms -->
@extends('layouts/cms')

{{-- Content --}}
@section('content')

    <!-- Breadcrumb -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12" id="msgBox">
                    </div>
                </div>
                <input type="hidden" class="form-control" id="id" name="id">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">                    
                        <select class="form-select" name="role" id="role" aria-label="Default select example" disabled>
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-9">                    
                        <select class="form-select" name="jabatan" id="jabatan" aria-label="Default select example" disabled>
                            <option value="">-- Select Jabatan --</option>
                            <option value="Kepala Subbagian Tata Usaha">Kepala Subbagian Tata Usaha</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-input btn-dark" onClick="save()">Update Profile</button>
                </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

@endsection

@section('jquery')
<!-- JQUERY -->
<script src="{{ asset('jquery/profile.js') }}"></script>
@endsection