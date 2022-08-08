<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaoUsuarioController extends Controller
{
    //
    public function index(Request $request) {

        /*$this->validate($request, [
            'consultor' => 'required',
            'mes_emissao' => 'required',
            'ano_emissao' => 'required'
        ]);*/

        return view('perfomance.consultores')
        ->with(
            [
                'consultores' => $this->getConsultores(), 
                'receita_comissao' => $this->getReceitaeComissao(
                    'Ana Paula Fontes Martins Chiodaro', 
                    1, 
                    2007, 
                    12, 
                    2022),
                'custo_fixo' => $this->getCustoFixo('Ana Paula Fontes Martins Chiodaro')
            ]
            
        );
    }

    public function getConsultores()
    {
        $consultores = DB::select("
        SELECT 
            cao_usuario.no_usuario 
        FROM 
            cao_usuario
        INNER JOIN (permissao_sistema)
        ON
            cao_usuario.co_usuario = permissao_sistema.co_usuario
        AND
            permissao_sistema.co_sistema = 1
        AND 
            permissao_sistema.in_ativo = 's'
        AND
            (
                permissao_sistema.co_tipo_usuario = 0
            OR
                permissao_sistema.co_tipo_usuario = 1
            OR
                permissao_sistema.co_tipo_usuario = 2
            )"
        );

        return $consultores;
    }

    
    public function getCustoFixo(string $consultor) {
        $custoFixo = DB::select("
            SELECT 
                brut_salario
            FROM
                cao_salario
            INNER JOIN
                (cao_usuario)
            ON
                cao_salario.co_usuario = cao_usuario.co_usuario
            AND
                cao_usuario.no_usuario = :nome_consultor
        ", ['nome_consultor' => $consultor]);

        return $custoFixo;
    }

    public function getReceitaeComissao(
        string $consultor, 
        int $mes_inicio, 
        int $ano_inicio,
        int $mes_fim,
        int $ano_fim) {

        $comissao = DB::select("
            SELECT 
                faturacao.consultor AS consultor, 
                faturacao.receita_liquida AS receita_liquida,
                (faturacao.receita_liquida * (faturacao.percentagem_comissao/100)) AS comissao,
                faturacao.mes_emissao AS mes_emissao,
                faturacao.ano_emissao AS ano_emissao
            FROM 
                (SELECT
                    cao_usuario.no_usuario AS consultor,
                    SUM(cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc/100))) AS receita_liquida, 
                    SUM(cao_fatura.comissao_cn) AS percentagem_comissao,
                    MONTH(cao_fatura.data_emissao) AS mes_emissao,
                    YEAR(cao_fatura.data_emissao) AS ano_emissao
                FROM 
                    cao_usuario 
                INNER JOIN 
                    (cao_fatura) 
                INNER JOIN 
                    (cao_os) 
                ON 
                    cao_os.co_usuario = cao_usuario.co_usuario
                AND 
                    cao_os.co_os = cao_fatura.co_os 
                AND 
                    cao_usuario.no_usuario = :nome_consultor
                AND 
                    MONTH(cao_fatura.data_emissao) >= :mes_inicio
                AND
                    MONTH(cao_fatura.data_emissao) <= :mes_fim    
                AND 
                    YEAR(cao_fatura.data_emissao) >= :ano_inicio
                AND
                    YEAR(cao_fatura.data_emissao) <= :ano_fim
                GROUP BY consultor, mes_emissao, ano_emissao
                ORDER BY mes_emissao) faturacao
            GROUP BY consultor, receita_liquida, comissao, mes_emissao,  ano_emissao    
        ", [
            'nome_consultor' => $consultor, 
            'mes_inicio' => $mes_inicio, 
            'ano_inicio' => $ano_inicio, 
            'mes_fim' => $mes_fim, 
            'ano_fim' => $ano_fim]);

        return $comissao;
    }
    
}
