@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Consignment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                            <li class="breadcrumb-item active">Create Consignment</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Total</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (session('parcelCart'))
                                    {{-- {{ dd(session('parcelCart')) }}
                                    --}}
                                    @foreach (session('parcelCart') as $details)
                                        {{ $details['desc'] }}<br />
                                        {{ $details['price'] }}
                                    @endforeach
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.card -->


@endsection

@section('script')
    <script>
        document.getElementById("blastMessage").className = "nav-link active";

    </script>
@endsection

