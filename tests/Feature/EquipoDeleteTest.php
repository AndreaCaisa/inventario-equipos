<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_eliminar_un_equipo_existente(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->delete(route('equipos.destroy', $equipo));

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseMissing('equipos', ['id' => $equipo->id]);
    }

    /** @test */
    public function muestra_mensaje_al_eliminar(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->delete(route('equipos.destroy', $equipo));

        $response->assertSessionHas('exito');
    }

    /** @test */
    public function eliminar_un_equipo_no_afecta_a_los_demas(): void
    {
        $equipos = Equipo::factory()->count(3)->create();
        $aEliminar = $equipos->first();

        $this->delete(route('equipos.destroy', $aEliminar));

        $this->assertDatabaseCount('equipos', 2);
    }

    /** @test */
    public function eliminar_un_equipo_que_no_existe_devuelve_404(): void
    {
        $response = $this->delete(route('equipos.destroy', 9999));

        $response->assertStatus(404);
    }

    /** @test */
    public function el_equipo_eliminado_ya_no_aparece_en_el_listado(): void
    {
        $equipo = Equipo::factory()->create(['nombre' => 'Equipo Temporal']);
        $this->delete(route('equipos.destroy', $equipo));

        $response = $this->get(route('equipos.index'));

        $response->assertDontSee('Equipo Temporal');
    }

    
}
