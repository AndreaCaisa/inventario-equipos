<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoEditUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_pagina_de_edicion_responde_200(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->get(route('equipos.edit', $equipo));

        $response->assertStatus(200);
        $response->assertViewIs('equipos.edit');
    }

    /** @test */
    public function la_pagina_de_edicion_muestra_los_datos_actuales(): void
    {
        $equipo = Equipo::factory()->create(['nombre' => 'Impresora HP LaserJet']);

        $response = $this->get(route('equipos.edit', $equipo));

        $response->assertSee('Impresora HP LaserJet');
    }

    /** @test */
    public function editar_un_equipo_que_no_existe_devuelve_404(): void
    {
        $response = $this->get(route('equipos.edit', 9999));

        $response->assertStatus(404);
    }

    /** @test */
    public function puede_actualizar_el_nombre_de_un_equipo(): void
    {
        $equipo = Equipo::factory()->create(['nombre' => 'Nombre viejo']);

        $response = $this->put(route('equipos.update', $equipo), [
            'nombre' => 'Nombre nuevo',
            'tipo'   => $equipo->tipo,
            'estado' => $equipo->estado,
        ]);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'nombre' => 'Nombre nuevo']);
    }

    /** @test */
    public function puede_actualizar_el_estado_de_un_equipo(): void
    {
        $equipo = Equipo::factory()->create(['estado' => 'disponible']);

        $this->put(route('equipos.update', $equipo), [
            'nombre' => $equipo->nombre,
            'tipo'   => $equipo->tipo,
            'estado' => 'mantenimiento',
        ]);

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'estado' => 'mantenimiento']);
    }

    /** @test */
    public function puede_actualizar_la_marca_de_un_equipo(): void
    {
        $equipo = Equipo::factory()->create(['marca' => 'Dell']);

        $this->put(route('equipos.update', $equipo), [
            'nombre' => $equipo->nombre,
            'tipo'   => $equipo->tipo,
            'estado' => $equipo->estado,
            'marca'  => 'HP',
        ]);

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'marca' => 'HP']);
    }

    /** @test */
    public function puede_actualizar_la_ubicacion_de_un_equipo(): void
    {
        $equipo = Equipo::factory()->create(['ubicacion' => 'Laboratorio 1']);

        $this->put(route('equipos.update', $equipo), [
            'nombre'    => $equipo->nombre,
            'tipo'      => $equipo->tipo,
            'estado'    => $equipo->estado,
            'ubicacion' => 'Laboratorio 2',
        ]);

        $this->assertDatabaseHas('equipos', ['id' => $equipo->id, 'ubicacion' => 'Laboratorio 2']);
    }

    /** @test */
    public function rechaza_actualizacion_sin_nombre(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->put(route('equipos.update', $equipo), [
            'nombre' => '',
            'tipo'   => $equipo->tipo,
            'estado' => $equipo->estado,
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    /** @test */
    public function rechaza_actualizacion_con_estado_invalido(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->put(route('equipos.update', $equipo), [
            'nombre' => $equipo->nombre,
            'tipo'   => $equipo->tipo,
            'estado' => 'no_existe',
        ]);

        $response->assertSessionHasErrors('estado');
    }

    /** @test */
    public function muestra_mensaje_de_exito_al_actualizar(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->put(route('equipos.update', $equipo), [
            'nombre' => $equipo->nombre,
            'tipo'   => $equipo->tipo,
            'estado' => $equipo->estado,
        ]);

        $response->assertSessionHas('exito');
    }

    /** @test */
    public function actualizar_no_crea_un_registro_nuevo(): void
    {
        $equipo = Equipo::factory()->create();

        $this->put(route('equipos.update', $equipo), [
            'nombre' => 'Actualizado',
            'tipo'   => $equipo->tipo,
            'estado' => $equipo->estado,
        ]);

        $this->assertDatabaseCount('equipos', 1);
    }

    /** @test */
    public function actualizar_un_equipo_que_no_existe_devuelve_404(): void
    {
        $response = $this->put(route('equipos.update', 9999), [
            'nombre' => 'Cualquiera',
            'tipo'   => 'Laptop',
            'estado' => 'disponible',
        ]);

        $response->assertStatus(404);
    }
}
