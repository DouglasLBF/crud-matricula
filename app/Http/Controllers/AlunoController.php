<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Aluno;
use App\Models\Curso;
use DataTables;

class AlunoController extends Controller
{
    public function index(Request $request)
    {

        $alunos = DB::table('alunos')
                    ->join('cursos','alunos.curso_id','=','cursos.id')
                    ->select('alunos.id','alunos.nome','alunos.email','cursos.nome_curso')
                    ->get();


        $cursos = Curso::get();

        if($request->ajax()){
            $Data_alunos = DataTables::of($alunos)
            ->addColumn('acoes', function($row){

                return "<a href='javascript:void(0)' data-toggle='tooltip'
                data-id='$row->id'
                data-original-title='Editar'
                class='edit btn btn-primary btn-sm editarAluno'>Editar</a>

                <a href='javascript:void(0)' data-toggle='tooltip'
                data-id='$row->id'
                data-original-title='Deletar'
                class='edit btn btn-danger btn-sm deletarAluno'>Deletar</a>
                ";
            })
            ->rawColumns(['acoes'])
            ->make(true);

            $Data_cursos = DataTables::of($cursos);

            return $Data_alunos;
        }

        return view('alunos')->with(compact('alunos','cursos'));
    }

    public function store(Request $request){
        Aluno::updateOrCreate(
            ['id'=>$request -> aluno_id],
            [
                'nome'=>$request->nome,
                'email'=>$request->email,
                'curso_id'=>$request->curso_selecionado,
            ]
        );
        return response() -> json(['success' => 'Aluno adicionado com sucesso!']);
    }

    public function destroy($id){
        Aluno::find($id)->delete();
        return response() -> json(['success' => 'Aluno deletado com sucesso!']);
    }

    public function edit($id)
    {
        $aluno = Aluno::find($id);
        return response()->json($aluno);
    }
}
