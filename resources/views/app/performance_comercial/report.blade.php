<div class="card card-report">
    <div class="card-body">
        @foreach ($consultants as $consultantSelected)
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr colspan="5">
                            <h5>{{ $consultantSelected[0] }}</h5>
                        </tr>
                        <tr style="background-color: lightblue">
                            <th>{{'Período (mês/ano)'}}</th>
                            <th>Receita Líquida</th>
                            <th>Custo Fixo</th>
                            <th>Comissão</th>
                            <th>Lucro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consultantSelected[1] as $performanceComercial)
                            <tr>
                                <td>{{ $performanceComercial->getDate() }}</td>
                                <td>{{ 'R$ ' . $performanceComercial->getNetIncome() }}</td>
                                <td>{{ 'R$ ' . $performanceComercial->getFixedCost() }}</td>
                                <td>{{ 'R$ ' . $performanceComercial->getComission() }}</td>
                                @if ($performanceComercial->getProfit() < 0)
                                    <td style="color: red ">
                                        {{ 'R$ ' . $performanceComercial->getProfit() }}
                                    </td>
                                @else
                                    <td>
                                        {{ 'R$ ' . $performanceComercial->getProfit() }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        <tr style="background-color: lightgray">
                            <td style="font-weight: bold">
                                Saldo
                            </td>
                            <td>{{ 'R$ ' . $consultantSelected[2][0] }}</td>
                            <td>{{ 'R$ ' . $consultantSelected[2][1] }}</td>
                            <td>{{ 'R$ ' . $consultantSelected[2][2] }}</td>
                            @if ($consultantSelected[2][3] < 0)
                                <td style="color: red">{{ 'R$ ' . $consultantSelected[2][3] }}</td>
                            @else
                                <td style="color: blue">{{ 'R$ ' . $consultantSelected[2][3] }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div><!-- /.card-body -->

</div>
