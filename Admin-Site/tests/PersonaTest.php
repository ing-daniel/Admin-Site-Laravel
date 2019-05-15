<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 
class PersonaTest extends TestCase
{

    use WithoutMiddleware; 
    use DatabaseMigrations;
 
    public function testPersonaCreate()
    {
        $data = $this->getData();

        $this->post('/persona', $data)
            ->seeJsonEquals(['created' => true]);
 
        $data = $this->getData(['nombre' => 'Macareno']);

        $this->put('/persona/1', $data)
            ->seeJsonEquals(['updated' => true]);
 

        $this->get('persona/1')->seeJson(['nombre' => 'Macareno']);
 
        $this->delete('persona/1')->seeJson(['deleted' => true]);
    }
 
    public function getData($custom = array())
    {
        $data = [
            'nombre'      => 'joe',
            'correo'     => 'joe@doe.com',
            'fechaNacimiento'  => '2015-06-11'
            ];
        $data = array_merge($data, $custom);
        return $data;
    }
}