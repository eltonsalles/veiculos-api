<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/fontawesome-all.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/4.1.1/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>BWCS</title>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center bwcs-barra-superior">
        <div class="col-5">
            <i class="fas fa-tint"> <span>FULLSTACK</span></i>
        </div>
        <div class="col-5">
            <input type="text" id="bwcs-buscar-veiculo" placeholder="BUSCA por um veículo">
        </div>
    </div>
    <div class="row justify-content-center align-items-center bwcs-add-veiculo">
        <div class="col-9 border-bottom">
            VEÍCULO
        </div>
        <div class="col-1 border-bottom">
            <i class="fas fa-plus-circle fa-2x" data-toggle="modal" data-target="#exampleModal" id="bwcs-novo-veiculo"></i>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-5" id="bwcs-lista-veiculo">
            <h6>Lista de veículos</h6>
        </div>
        <div class="col-5" id="bwcs-detalhes-veiculo">
            <h6>Detalhes</h6>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo Veículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 bwcs-mensagem-erro">
                            <div class="alert alert-danger d-none" role="alert"></div>
                        </div>
                    </div>
                    <form>
                        <input type="hidden" id="id">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="veiculo">Veículo</label>
                                <input type="text" class="form-control" id="veiculo">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control" id="marca">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="ano">Ano</label>
                                <input type="text" class="form-control" id="ano">
                            </div>
                            <div class="form-group col-sm-6">
                                <br>
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="vendido">
                                    <label class="custom-control-label" for="vendido">Vendido</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="enviar-form">ADD</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('lib/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('lib/popper/popper-1.14.3.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/4.1.1/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>