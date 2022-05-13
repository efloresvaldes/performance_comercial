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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <label>Período</label>
                                </div>
                                <div class="card-body">
                                     <div class="row">
                                         <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label>Mês Inicial</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input autocomplete="off" type="text" class="form-control float-right" id="periodStart">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                         </div>
                                         <div class="col-md-6">
                                            <label>Mês Final</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input autocomplete="off" type="text" class="form-control float-right" id="periodEnd">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                         </div>
                                     </div>
                                </div>

                            </div>
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Consultores</label>
                                <select class="duallistbox" id="consultantsSelect" multiple="multiple">
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
                            <button type="button" id="report" class="btn btn-success">Relatório</button>
                            <button type="button" id="barchartBtn" class="btn btn-info">Gráfico</button>
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
        <div class="col-md-12">
            <canvas id="barchart"></canvas>
        </div>
        <div class="col-md-12">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
   
@endsection
@section('page_scripts')
@endsection
