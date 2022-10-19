<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Criar produto</title>
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
        <form action="{{route("userinfo.store")}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id-input-Users_id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id-input-Users_id" aria-describedby="idHelp" placeholder="#" disabled>
                <div id="Users_id" class="form-text">Não será necessário cadastrar um id</div>
            </div>
            <div class="form-group">
                <label for="id-input-profileImg" class="form-label">Imagem de Perfil</label>
                <input name="profileImg" type="text" class="form-control" id="id-input-profileImg" placeholder="Digite o profileImg" required>
            </div>
            <div class="form-group">
                <label for="id-input-status" class="form-label">Status do Perfil</label>
                <input name="status" type="text" class="form-control" id="id-input-status" placeholder="#" disabled>
            </div>
            <div class="form-group">
                <label for="id-input-dataNasc" class="form-label">Data de Nascimento</label>
                <input name="dataNasc" type="text" class="form-control" id="id-input-dataNasc" placeholder="Digite a data de nascimento" required>
            </div>
            <div class="form-group">
                <label for="id-input-genero" class="form-label">Gênero</label>
                <input name="genero" type="text" class="form-control" id="id-input-genero" placeholder="Digite a data de nascimento" required>
            </div>
            <div class="my-1">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
    </div>
</body>
</html>