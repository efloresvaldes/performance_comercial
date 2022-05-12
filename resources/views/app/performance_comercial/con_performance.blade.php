@extends('layout.content')
@section('page_css')
    <!-- Bootstrap4 DaterangePicker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endsection

@section('page_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Performance Comercial</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('page_content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Por Consultor
                    </h3>

                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Período</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="period">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Consultores</label>
                                <select class="duallistbox" multiple="multiple">
                                    @foreach ($consultants as $consultant)
                                        <option value={{$consultant->user_name}}>{{$consultant->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div><!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-md-12 d-flex justify-content-end">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success">Relatorio</button>
                            <button type="button" class="btn btn-info">Gráfico</button>
                            <button type="button" class="btn btn-warning">Pizza</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12" id="reportDiv">
            
        </div>
    </div>
@endsection
@section('page_scripts')
@endsection
