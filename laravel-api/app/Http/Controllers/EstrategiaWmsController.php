<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstrategiaWmsRequest;

use App\Models\TbEstrategiaWms;
use App\Models\TbEstrategiaWmsHorarioPrioridade;

use Illuminate\Http\Request;

class EstrategiaWmsController extends Controller
{
    public function getEstrategia($cdEstrategia, $dsHora, $dsMinuto)
    {
        // Se recebido apenas um dígito nos minutos, insere um 0 a esquerda
        $dsMinuto = str_pad($dsMinuto, 2, '0', STR_PAD_LEFT);

        // Variável para armazenar hora formatada
        $horaFormatada = $dsHora . ':' . $dsMinuto;

        // Regex para validar se a hora é valida
        if(!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $horaFormatada)){
            return response()->json(['error' => 'O formato de hora e minuto é inválido.'], 400);
        }

        // Se não encontrar a Estratégia retorna erro
        if(!$estrategia = TbEstrategiaWms::find($cdEstrategia)){
            return response()->json(['error' => 'Estratégia não encontrada, verifique a estratégia informada.'], 404);
        }

        // Retona a prioridade com base na hora e minuto
        if($horario = TbEstrategiaWmsHorarioPrioridade::where('cd_estrategia_wms', $cdEstrategia)
                                                                ->where('ds_horario_inicio', '<=', $horaFormatada)
                                                                ->where('ds_horario_final', '>=', $horaFormatada)
                                                                ->first()) {
            return response()->json(['prioridade' => $horario->nr_prioridade], 200);
        }

        // Se o Horário estiver fora do definido, retorna a prioridade padrão da estratégia
        return response()->json(['prioridade' => $estrategia->nr_prioridade], 200);
    }

    public function storeEstrategia(StoreEstrategiaWmsRequest $request)
    {
        // Variável para retornar todos os dados recebidos
        $dados = $request->all();

        // Criar na tabela tb_estrategia_wms os dados recebidos
        $estrategia = TbEstrategiaWms::create([
            'ds_estrategia_wms' => $request->dsEstrategia,
            'nr_prioridade' => $request->nrPrioridade,
        ]);

         // Criar na tabela tb_estrategia_wms_horario_prioridade os dados recebidos
        foreach($request->horarios as $horario){
            TbEstrategiaWmsHorarioPrioridade::create([
                'cd_estrategia_wms' => $estrategia->cd_estrategia_wms,
                'ds_horario_inicio' => $horario['dsHorarioInicio'],
                'ds_horario_final' => $horario['dsHorarioFinal'],
                'nr_prioridade' => $horario['nrPrioridade'],
            ]);
        }

        // Retorno com mensagem e dados recebidos, caso sucesso
        return response()->json([
            'mensagem' => 'Dados de Estratégia criados com sucesso!',
            'retorno' => $dados
        ], 201);
    }
}
