$(function () {
    buscarVeiculos();

    let enviarForm = $('#enviar-form');
    enviarForm.click(function () {
       if ($('#exampleModalLabel').text().toLowerCase() === 'novo veículo') {
           formulario('Veículo cadastrado com sucesso', 'POST');
       } else {
           formulario('Veículo alterado com sucesso', 'PUT', $('#id').val());
       }
    });

    $('#bwcs-novo-veiculo').click(function () {
       $('#exampleModalLabel').text('Novo Veículo');
       limparFormulario();
    });

    $('#bwcs-buscar-veiculo').keyup(function (e) {
        if (e.which === 13) {
            procurarVeiculo($(this).val());
        }
    });
});

function buscarVeiculos() {
    limparLista();

    $.ajax({
        url: 'http://localhost:8080/api/v1/veiculos',
        method: 'GET',
        headers: {
            Accept: 'application/json'
        },
        success: function (data) {
            let containerVeiculos = $('#bwcs-lista-veiculo');
            for (let i = 0; i < data.data.length; i++) {
                containerVeiculos.append(listarVeiculo(data.data[i]));
            }

            let veiculos = containerVeiculos.find('article');
            for (let i = 0; i < veiculos.length; i++) {
                $(veiculos[i]).click(function () {
                    detalhesVeiculo($(veiculos[i]).find('span').text());
                });
            }
        },
        error: function (error) {
            console.log('Erro:', error)
        }
    });
}

function listarVeiculo(veiculo) {
    let article = $('<article>').addClass('row align-items-center');
    let div1 = $('<div>').addClass('col-10');
    let div2 = $('<div>').addClass('col-2');
    let p1 = $('<p>');
    let p2 = $('<p>');
    let p3 = $('<p>');
    let i = $('<i>').addClass('fas fa-tag');
    let span = $('<span>').addClass('d-none');

    p1.text(veiculo.marca);
    p2.text(veiculo.veiculo);
    p3.text(veiculo.ano);
    span.text(veiculo.id);

    div1.append(p1);
    div1.append(p2);
    div1.append(p3);
    article.append(div1);

    if (veiculo.vendido === 1) {
        i.addClass('bwcs-vendido');
    }
    div2.append(i);
    article.append(div2);
    article.append(span);

    return article;
}

function detalhesVeiculo(id) {
    limparDetalhes();

    $.ajax({
        url: `api/v1/veiculos/${id}`,
        method: 'GET',
        headers: {
            Accept: 'application/json'
        },
        success: function (data) {
            let containerDetalhes = $('#bwcs-detalhes-veiculo');
            containerDetalhes.append(detalhes(data.id, data.veiculo, data.marca, data.ano, data.descricao, data.vendido));
        },
        error: function (error) {
            console.log(error);
        }
    });

    function detalhes(id, veiculo, marca, ano, descricao, vendido) {
        let article = $('<article>').addClass('col-12');
        let pTextoVeiculo = $('<p>').text(veiculo).addClass('bwcs-veiculo');
        let divRow1 = $('<div>').addClass('row');
        let divCol1 = $('<div>').addClass('col-6 bwcs-marca-ano');
        let pMarca = $('<p>').text('Marca');
        let pTextoMarca = $('<p>').text(marca);
        let divCol2 = $('<div>').addClass('col-6 bwcs-marca-ano');
        let pAno = $('<p>').text('Ano');
        let pTextoAno = $('<p>').text(ano);
        let pTextoDescricao = $('<p>').text(descricao).addClass('bwcs-descricao');
        let divRow2 = $('<div>').addClass('row border-top bwcs-btn-vendido');
        let divCol3 = $('<div>').addClass('col-10');
        let button = $('<button>').addClass('btn btn-secondary').attr('type', 'button').attr('data-toggle', 'modal')
            .attr('data-target', '#exampleModal').text('EDITAR');
        let divCol4 = $('<div>').addClass('col-2');
        let i = $('<i>').addClass('fas fa-tag');
        let span = $('<span>').addClass('d-none').text(id);

        if (vendido === 1) {
            i.addClass('bwcs-vendido');
        }

        divCol1.append(pMarca);
        divCol1.append(pTextoMarca);
        divCol2.append(pAno);
        divCol2.append(pTextoAno);
        divRow1.append(divCol1);
        divRow1.append(divCol2);

        article.append(pTextoVeiculo);
        article.append(divRow1);

        button.click(function () {
            buscarVeiculo(id);
        });
        divCol3.append(button);
        divCol4.append(i);
        divRow2.append(divCol3);
        divRow2.append(divCol4);

        article.append(pTextoDescricao);
        article.append(divRow2);
        article.append(span);

        return article;
    }
}

function buscarVeiculo(id) {
    $('#exampleModalLabel').text('Editar Veículo');

    $.ajax({
        url: `api/v1/veiculos/${id}`,
        method: 'GET',
        headers: {
            Accept: 'application/json'
        },
        success: function (data) {
            $('#veiculo').val(data.veiculo);
            $('#marca').val(data.marca);
            $('#ano').val(data.ano);
            $('#descricao').val(data.descricao);
            if (data.vendido === 1) {
                $('#vendido').prop('checked', true);
            } else {
                $('#vendido').prop('checked', false);
            }
            $('#id').val(data.id);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function formulario(mensagem, method, id) {
    let mensagemErro = $('.bwcs-mensagem-erro div');
    let veiculo = $('#veiculo');
    let marca = $('#marca');
    let ano = $('#ano');
    let vendido = $('#vendido');
    let vendidoValue = 0;
    let descricao = $('#descricao');

    let patternTexto = /^([a-zA-Zà-úÀ-Ú])([a-zA-Zà-úÀ-Ú]|\.|\s)+$/;
    let patternDescricao = /^([a-zA-Zà-úÀ-Ú0-9])([a-zA-Zà-úÀ-Ú0-9]|,|\.|-|\s)+$/;
    let patternNumero = /^[0-9]{4}/;

    if (!patternTexto.test(veiculo.val())) {
        mensagemErro.removeClass('d-none');
        mensagemErro.text('');
        mensagemErro.text('O nome do veículo não está no padrão permitido.');
        return false;
    }

    if (!patternTexto.test(marca.val())) {
        mensagemErro.removeClass('d-none');
        mensagemErro.text('');
        mensagemErro.text('O nome da marca não está no padrão permitido.');
        return false;
    }

    if (!patternNumero.test(ano.val())) {
        mensagemErro.removeClass('d-none');
        mensagemErro.text('');
        mensagemErro.text('O ano deve conter os 4 digitos.');
        return false;
    }

    if (vendido.prop('checked')) {
        vendidoValue = 1;
    }

    if (!patternDescricao.test(descricao.val())) {
        mensagemErro.removeClass('d-none');
        mensagemErro.text('');
        mensagemErro.text('A descrição não está no padrão permitido.');
        return false;
    }

    let url;
    let data;
    if (id === undefined) {
        url = 'http://localhost:8080/api/v1/veiculos';
        data = { veiculo: veiculo.val(), marca: marca.val(), ano: ano.val(), vendido: vendidoValue,
            descricao: descricao.val() };
    } else {
        url = `http://localhost:8080/api/v1/veiculos/${id}`;
        data = { id: id, veiculo: veiculo.val(), marca: marca.val(), ano: ano.val(), vendido: vendidoValue,
            descricao: descricao.val() }
    }

    $.ajax({
        url: url,
        method: method,
        headers: {
            Accept: 'application/json'
        },
        data: data,
        success: function () {
            alert(mensagem);
            limparDetalhes();
            buscarVeiculos();
        },
        error: function (error) {
            console.log(error);
        },
        beforeSend: function () {
            limparFormulario();
            $('#exampleModal').modal('hide');
        }
    });
}

function limparFormulario() {
    $('.bwcs-mensagem-erro div').addClass('d-none').text('');
    $('#veiculo').val('');
    $('#marca').val('');
    $('#ano').val('');
    $('#vendido').prop('checked', false);
    $('#descricao').val('');
}

function limparDetalhes() {
    $('#bwcs-detalhes-veiculo article').remove();
}

function limparLista() {
    $('#bwcs-lista-veiculo article').remove();
}

function procurarVeiculo(nome) {
    limparLista();

    $.ajax({
        url: `api/v1/veiculos/find/?q=veiculo,${nome}`,
        method: 'GET',
        headers: {
            Accept: 'application/json'
        },
        success: function (data) {
            if (data.data.length > 0) {
                let containerVeiculos = $('#bwcs-lista-veiculo');
                for (let i = 0; i < data.data.length; i++) {
                    containerVeiculos.append(listarVeiculo(data.data[i]));
                }

                let veiculos = containerVeiculos.find('article');
                for (let i = 0; i < veiculos.length; i++) {
                    $(veiculos[i]).click(function () {
                        detalhesVeiculo($(veiculos[i]).find('span').text());
                    });
                }
            } else {
                alert('Nenhum veículo encontrado');
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}