<?php

namespace Tests\Feature;

use App\dao\ServiceFrais;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceFraisTest extends TestCase
{
    public function testGetFrais()
    {
        $id_visiteur = 1;

        $serviceFrais = new ServiceFrais();
        $lesFrais = $serviceFrais->getFrais($id_visiteur);

        $this->assertNotNull($lesFrais);
        $this->assertIsObject($lesFrais);
    }
}
