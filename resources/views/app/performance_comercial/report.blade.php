<div class="card card-report">
    <div class="card-body">
        @foreach ($consultants as $consultantSelected)
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr colspan="5"><h5>{{$consultantSelected[0]}}</h5></tr>
                        <tr>
                            <th>Periodo</th>
                            <th>Receita Líquida</th>
                            <th>Custo Fixo</th>
                            <th>Comissão</th>
                            <th>Lucro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consultantSelected[1] as $performanceComercial)
                        <tr>
                            <td>{{$performanceComercial->getMonth()}}</td>
                            <td>{{'R$ '.$performanceComercial->getNetIncome()}}</td>
                            <td>{{'R$ '.$performanceComercial->getFixedCost()}}</td>
                            <td>{{'R$ '.$performanceComercial->getComission()}}</td>
                            <td>{{'R$ '.$performanceComercial->getProfit()}}</td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endforeach
    </div><!-- /.card-body -->
  
</div>
