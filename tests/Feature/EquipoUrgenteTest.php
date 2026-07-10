<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoUrgenteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_marcar_un_equipo_como_urgente(): void
    {
        $equipo = Equipo::factory()->create(['urgente' => false]);

        $this->post(route('equipos.urgente', $equipo));

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'urgente' => true]);
    }

    /** @test */
    public function puede_quitar_el_estado_urgente_de_un_equipo(): void
    {
        $equipo = Equipo::factory()->create(['urgente' => true]);

        $this->post(route('equipos.urgente', $equipo));

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'urgente' => false]);
    }

    /** @test */
    public function marcar_urgente_redirige_al_listado(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->post(route('equipos.urgente', $equipo));

        $response->assertRedirect(route('equipos.index'));
    }

    /** @test */
    public function marcar_urgente_no_modifica_otros_campos(): void
    {
        $equipo = Equipo::factory()->create(['nombre' => 'Servidor Principal']);

        $this->post(route('equipos.urgente', $equipo));

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'nombre' => 'Servidor Principal']);
    }

    /** @test */
    public function el_listado_muestra_la_etiqueta_urgente(): void
    {
        Equipo::factory()->create(['urgente' => true]);

        $response = $this->get(route('equipos.index'));

        $response->assertSee('Urgente');
    }

    /** @test */
    public function marcar_urgente_en_equipo_inexistente_devuelve_404(): void
    {
        $response = $this->post(route('equipos.urgente', 9999));

        $response->assertStatus(404);
    }

    /** @test */
    public function marcar_urgente_dos_veces_vuelve_al_estado_original(): void
    {
        $equipo = Equipo::factory()->create(['urgente' => false]);

        $this->post(route('equipos.urgente', $equipo));
        $this->post(route('equipos.urgente', $equipo));

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'urgente' => false]);
    }
}
