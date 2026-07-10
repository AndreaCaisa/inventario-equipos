<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_pagina_de_listado_responde_200(): void
    {
        $response = $this->get(route('equipos.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function el_listado_usa_la_vista_correcta(): void
    {
        $response = $this->get(route('equipos.index'));

        $response->assertViewIs('equipos.index');
    }

    /** @test */
    public function el_listado_muestra_un_equipo_existente(): void
    {
        Equipo::factory()->create(['nombre' => 'Router TP-Link AC1200']);

        $response = $this->get(route('equipos.index'));

        $response->assertSee('Router TP-Link AC1200');
    }

    /** @test */
    public function el_listado_muestra_varios_equipos(): void
    {
        Equipo::factory()->count(5)->create();

        $response = $this->get(route('equipos.index'));
        $response->assertStatus(200);
        $response->assertViewHas('equipos', function ($equipos) {
            return $equipos->count() === 5;
        });
    }

    /** @test */
    public function el_listado_esta_vacio_cuando_no_hay_equipos(): void
    {
        $response = $this->get(route('equipos.index'));

        $response->assertSee('Aún no hay equipos registrados.');
    }

    /** @test */
    public function el_listado_ordena_los_equipos_del_mas_reciente_al_mas_antiguo(): void
    {
        $primero = Equipo::factory()->create(['nombre' => 'Equipo Antiguo', 'created_at' => now()->subDays(2)]);
        $segundo = Equipo::factory()->create(['nombre' => 'Equipo Reciente', 'created_at' => now()]);

        $response = $this->get(route('equipos.index'));
        $equipos = $response->viewData('equipos');

        $this->assertEquals($segundo->id, $equipos->first()->id);
    }

    /** @test */
    public function el_listado_muestra_el_badge_de_disponible(): void
    {
        Equipo::factory()->create(['estado' => 'disponible']);

        $response = $this->get(route('equipos.index'));
        $response->assertSee('Disponible');
    }

    /** @test */
    public function el_listado_muestra_el_badge_de_mantenimiento(): void
    {
        Equipo::factory()->create(['estado' => 'mantenimiento']);

        $response = $this->get(route('equipos.index'));
        $response->assertSee('Mantenimiento');
    }
}
