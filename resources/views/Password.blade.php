<!-- Menghubungkan dengan view template cms -->
@extends('layouts/cms')

{{-- Content --}}
@section('content')

    <!-- Breadcrumb -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password2" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password2" name="password" placeholder="Confirm Password" autofocus>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-input btn-dark" onClick="save()">Update Password</button>
                </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

@endsection

@section('jquery')
<!-- JQUERY -->
<script src="{{ asset('jquery/password.js') }}"></script>
@endsection