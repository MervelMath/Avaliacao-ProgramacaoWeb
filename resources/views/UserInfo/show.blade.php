<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show de User Infos</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        @if(isset($message))
            <div class="alert alert-{{$message[1]}} alert-dismissible fade show" role="alert">
                <span>{{$message[0]}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="my-3">
            <a href="{{route("userinfo.edit", $userInfos->Users_id)}}" method="POST" class="btn btn-primary">Editar</a>
            <a 
                                href="#" 
                                class="btn btn-danger class-button-destroy" 
                                data-bs-toggle="modal" 
                                data-bs-target="#destroyModal"
                                value="{{route("userinfo.destroy", $userInfos->Users_id)}}"> 
                                    Remover
            </a>
        </div>
        <div class="form-group">
            <label class="form-label">ID do Usuário</label>
            <input type="text" class="form-control" value={{$userInfos->Users_id}} disabled>
        </div>
        <div class="form-group">
            <label class="form-label">Imagem de Perfil</label>
            <input type="text" class="form-control" value={{$userInfos->profileImg}} disabled>
        </div>
        <div class="form-group">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value={{$userInfos->status}} disabled>
        </div>
        <div class="form-group">
            <label class="form-label">Data de Nascimento</label>
            <input type="text" class="form-control" value={{$userInfos->dataNasc}} disabled>
        </div>
        <div class="form-group">
            <label class="form-label">Gênero</label>
            <input type="text" class="form-control" value={{$userInfos->genero}} disabled>
        </div>
    </div>
    <!-- Modal -->
        <div class="modal fade" id="destroyModal" tabindex="-1" aria-labelledby="destroyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="destroyModalLabel">Confirmação de remoção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Deseja realmente remover este recurso?
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-danger">Confirmar remoção</button> --}}
                        <form id="id-form-modal-botao-remover" action="{{route("userinfo.destroy", $userInfos->Users_id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Confirmar remoção">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const arrayBtnRemover = document.querySelectorAll(".class-button-destroy");
            const formModalBotaoRemover = document.querySelector("#id-form-modal-botao-remover");
            //console.log(arrayBtnRemover);
            arrayBtnRemover.forEach(btnRemover => {
                btnRemover.addEventListener("click", configurarBotaoRemoverModal);
            });
            function configurarBotaoRemoverModal(){
                // Imprimindo o conteudo do atributo value do botão que chamou essa função
                //console.log( this.getAttribute("value") );
                //console.log(formModalBotaoRemover);
                formModalBotaoRemover.setAttribute("action", this.getAttribute("value"));
            }
        </script>
</body>
</html>