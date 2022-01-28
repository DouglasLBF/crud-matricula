<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Matrícula</title>
    <link rel="stylesheet" href="{{asset('site/style.scss.css')}}">
</head>

<body>
    <div class="container">
        <h1>Lista de alunos</h1>
        <button type="button" class="btn btn-success btn-cadastrar" id="btnCadastrarModal">
            Cadastrar Aluno
        </button>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="modal fade" id="AlunoModal" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AlunoModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="alunoForm" name="alunoForm" class="form-horizontal" >
                        <input type="hidden" name="aluno_id" id="aluno_id">
                        <div class="form-group">
                            Nome:<br>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Insira seu nome" value="" required>
                        </div>
                        <div class="form-group">
                            Email:<br>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Insira seu email" value="" required>
                        </div>
                        <div class="form-group">
                            Curso:<br>
                            <select class="form-select" id="selecionarCurso" name="curso_selecionado" focus required>
                                <option value="" disabled selected>Selecione o curso</option>
                                @foreach($cursos as $cursos)
                                <option value="{{$cursos->id}}">{{$cursos->nome_curso}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fechar</button>
                            <button type="submit" class="btn btn-primary" id="btnSalvar" value="Create">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('site/jquery.js')}}"></script>
    <script src="{{asset('site/bootstrap.js')}}"></script>
    <script src="{{asset('site/dataTables.js')}}"></script>
    <script src="{{asset('site/dataTables-bs5.js')}}"></script>
</body>

<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        var table=$(".data-table").DataTable({
            serverSide:true,
            processing:true,
            ajax:"{{route('alunos.index')}}",
            columns:[
                {data:'id',name:'id'},
                {data:'nome',name:'nome'},
                {data:'email',name:'email'},
                {data:'nome_curso',name:'nome_curso'},
                {data:'acoes',name:'acoes'}
            ]
        });

        $("#btnCadastrarModal").click(function(){
            $("#aluno_id").val('');
            $("#alunoForm").trigger("reset");
            $("#AlunoModalLabel").html("Cadastrar");
            $("#AlunoModal").modal('show');
        });

        $("#btnSalvar").click(function(e){
            e.preventDefault();
            console.log(e);
            $(this).html('Salvar');
            $.ajax({
                data:$("#alunoForm").serialize(),
                url:"{{route('alunos.store')}}",
                type:"POST",
                datatype:'json',
                success:function(data){
                    $("alunoForm").trigger("reset");
                    $("#AlunoModal").modal('hide');
                    table.draw();
                },
                error:function(data){
                    console.log('Error',data);
                    $("#btnSalvar").html('Salvar');
                }
            })
        });

        $('body').on('click','.deletarAluno',function(){
            var aluno_id = $(this).data("id");
            if(confirm('Tem certeza que quer deletar este Aluno?')){
                $.ajax({
                    type:"DELETE",
                    url:"{{route('alunos.store')}}"+'/'+aluno_id,
                    success:function(data){
                        table.draw();
                    },
                    error: function(data){
                        console.log('Error'.data);
                    }
                });
            } ;

        })

        $('body').on('click','.editarAluno',function(){
            var aluno_id = $(this).data("id");

            $.get("{{route('alunos.index')}}"+"/"+aluno_id+"/edit",function(data){
                $("#AlunoModalLabel").html("Editar Aluno");
                $('#AlunoModal').modal('show');
                $('#aluno_id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#selecionarCurso').val(data.curso_id);
            })

        })
    })
    </script>

</html>
