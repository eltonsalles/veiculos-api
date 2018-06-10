<?php

namespace Tests\Feature;

use App\Veiculo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VeiculoTest extends TestCase
{
    use DatabaseMigrations;

    const URI_API = '/api/v1/veiculos';

    public function testIndexSimpleList()
    {
        $data = $this->builderVeiculos();

        $response = $this->json('GET', self::URI_API);

        $response
            ->assertStatus(200)
            ->assertJson(['data' => $data->toArray()]);
    }

    public function testIndexListLimit()
    {
        $data = $this->builderVeiculos(5);

        $response = $this->json('GET', self::URI_API . '?limit=5');

        $response
            ->assertStatus(200)
            ->assertJson(['data' => $data->toArray()]);
    }

    public function testIndexListLimitInvalid()
    {
        $response = $this->json('GET', self::URI_API . '?limit=e');

        $data = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'limit' => ['The limit must be an integer.']
            ]
        ];

        $response
            ->assertStatus(422)
            ->assertJson($data);
    }

    public function testIndexListLike()
    {
        $this->builderVeiculos();
        $data = Veiculo::where('marca', 'like', '%inc%')->get();

        $response = $this->json('GET', self::URI_API . '/find?q=marca,inc');

        $response
            ->assertStatus(200)
            ->assertJson(['data' => $data->toArray()]);
    }

    public function testIndexListLikeInvalid()
    {
        $response = $this->json('GET', self::URI_API . '?q=column,condition');

        $data = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'q' => ['The q format is invalid.']
            ]
        ];

        $response
            ->assertStatus(422)
            ->assertJson($data);
    }

    public function testShow()
    {
        $this->builderVeiculos(1);
        $data = Veiculo::find(1);

        $response = $this->json('GET', self::URI_API . '/1');

        $response
            ->assertStatus(200)
            ->assertJson($data->toArray());
    }

    public function testShowInvalidId()
    {
        $response = $this->json('GET', self::URI_API . '/1');

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'record not found']);
    }

    public function testUpdate()
    {
        $this->builderVeiculos(1);

        $data = Veiculo::find(1);
        $data->marca = "Veiculo Teste";

        $response = $this->json('PUT', self::URI_API . '/1', $data->toArray());

        $data = Veiculo::find(1);

        $response
            ->assertStatus(200)
            ->assertJson($data->toArray());
    }

    public function testUpdateInvalidId()
    {
        $data['veiculo'] = 'teste';
        $data['marca'] = 'teste inc';
        $data['ano'] = 2000;
        $data['descricao'] = 'descricao teste';
        $data['vendido'] = 0;

        $response = $this->json('PUT', self::URI_API . '/1', $data);

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'record not found']);
    }

    public function testUpdateInvalidData()
    {
        $response = $this->json('PUT', self::URI_API . '/1', $data = []);

        $response
            ->assertStatus(422);
    }

    public function testUpdatePatch()
    {
        $this->builderVeiculos(1);

        $data = Veiculo::find(1);
        $data->marca = "Veiculo Teste";

        $response = $this->json('PATCH', self::URI_API . '/1', $data->toArray());

        $data = Veiculo::find(1);

        $response
            ->assertStatus(200)
            ->assertJson($data->toArray());
    }

    public function testUpdateInvalidIdPatch()
    {
        $data['veiculo'] = 'teste';
        $data['marca'] = 'teste inc';
        $data['ano'] = 2000;
        $data['descricao'] = 'descricao teste';
        $data['vendido'] = 0;

        $response = $this->json('PATCH', self::URI_API . '/1', $data);

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'record not found']);
    }

    public function testUpdateInvalidDataPatch()
    {
        $response = $this->json('PATCH', self::URI_API . '/1', $data = []);

        $response
            ->assertStatus(422);
    }

    public function testDestroy()
    {
        $this->builderVeiculos();
        $data = Veiculo::find(1);

        $response = $this->json('DELETE', self::URI_API . '/1');

        $response
            ->assertStatus(200)
            ->assertJson($data->toArray());
    }

    public function testDeleteInvalidId()
    {
        $response = $this->json('GET', self::URI_API . '/1');

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'record not found']);
    }

    private function builderVeiculos($quantity = 10)
    {
        $data = factory(Veiculo::class, $quantity)->create();

        return $data;
    }
}
