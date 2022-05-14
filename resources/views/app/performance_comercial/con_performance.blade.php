@extends('layout.content')
@section('page_css')
    <!-- Bootstrap4 DaterangePicker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        Por Consultor
                    </h3>

                </div><!-- /.card-header -->
                <form id="searchConsultants">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-success">
                                    <div class="card-header" style="font-weight: bold">
                                        Período
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
                                                        <input autocomplete="off" placeholder="Seleccione o mês de início"
                                                            type="text"  class="form-control"
                                                            id="periodStart" name="periodStart">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="inputFinal">
                                                <label>Mês Final</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </span>
                                                        </div>

                                                        <input autocomplete="off" placeholder="Seleccione o mês final"
                                                            type="text" class="form-control " id="periodEnd" name="periodEnd">
                                                            
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
                                    <select class="duallistbox" id="consultantsSelect" name="consultantsSelect" multiple="multiple">
                                        @foreach ($consultants as $consultant)
                                            <option value={{ $consultant->user_name }}>{{ $consultant->fullname }}
                                            </option>
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
                                <button type="button" id="piechartBtn" class="btn btn-warning">Pizza</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12" id="reportDiv">

        </div>
        <div class="col-md-12" id="chartDiv">
            <canvas id="charts"> </canvas>
        </div>



    </div>
@endsection
@section('page_scripts')
@endsection
