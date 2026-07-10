<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_pagina_de_creacion_responde_200(): void
    {
        $response = $this->get(route('equipos.create'));

        $response->assertStatus(200);
        $response->assertViewIs('equipos.create');
    }

    /** @test */
    public function puede_crear_un_equipo_con_datos_validos(): void
    {
        $datos = [
            'nombre'    => 'PC de Escritorio 12',
            'tipo'      => 'Computadora',
            'marca'     => 'Lenovo',
            'estado'    => 'disponible',
            'ubicacion' => 'Laboratorio 1',
        ];

        $response = $this->post(route('equipos.store'), $datos);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['nombre' => 'PC de Escritorio 12']);
    }

    /** @test */
    public function muestra_mensaje_de_exito_al_crear(): void
    {
        $datos = [
            'nombre' => 'Proyector Epson X200',
            'tipo'   => 'Proyector',
            'estado' => 'disponible',
        ];

        $response = $this->post(route('equipos.store'), $datos);

        $response->assertSessionHas('exito');
    }

    /** @test */
    public function rechaza_creacion_sin_nombre(): void
    {
        $response = $this->post(route('equipos.store'), [
            'tipo'   => 'Laptop',
            'estado' => 'disponible',
        ]);

        $response->assertSessionHasErrors('nombre');
        $this->assertDatabaseCount('equipos', 0);
    }

    /** @test */
    public function rechaza_creacion_sin_tipo(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Impresora HP',
            'estado' => 'disponible',
        ]);

        $response->assertSessionHasErrors('tipo');
        $this->assertDatabaseCount('equipos', 0);
    }

    /** @test */
    public function rechaza_creacion_sin_estado(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Impresora HP',
            'tipo'   => 'Impresora',
        ]);

        $response->assertSessionHasErrors('estado');
    }

    /** @test */
    public function rechaza_un_estado_que_no_existe_en_la_lista_permitida(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Impresora HP',
            'tipo'   => 'Impresora',
            'estado' => 'estado_invalido',
        ]);

        $response->assertSessionHasErrors('estado');
    }

    /** @test */
    public function acepta_creacion_sin_marca_porque_es_opcional(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Router Genérico',
            'tipo'   => 'Router',
            'estado' => 'disponible',
        ]);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['nombre' => 'Router Genérico', 'marca' => null]);
    }

    /** @test */
    public function acepta_creacion_sin_ubicacion_porque_es_opcional(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Switch de Red',
            'tipo'   => 'Switch',
            'estado' => 'disponible',
        ]);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['nombre' => 'Switch de Red', 'ubicacion' => null]);
    }

    /** @test */
    public function rechaza_un_nombre_mayor_a_120_caracteres(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => str_repeat('a', 121),
            'tipo'   => 'Laptop',
            'estado' => 'disponible',
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    /** @test */
    public function rechaza_un_tipo_mayor_a_60_caracteres(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Equipo de prueba',
            'tipo'   => str_repeat('b', 61),
            'estado' => 'disponible',
        ]);

        $response->assertSessionHasErrors('tipo');
    }

    /** @test */
    public function acepta_estado_en_uso(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Laptop en préstamo',
            'tipo'   => 'Laptop',
            'estado' => 'en_uso',
        ]);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['estado' => 'en_uso']);
    }

    /** @test */
    public function acepta_estado_mantenimiento(): void
    {
        $response = $this->post(route('equipos.store'), [
            'nombre' => 'Impresora dañada',
            'tipo'   => 'Impresora',
            'estado' => 'mantenimiento',
        ]);

        $response->assertRedirect(route('equipos.index'));
        $this->assertDatabaseHas('equipos', ['estado' => 'mantenimiento']);
    }

    /** @test */
    public function un_equipo_nuevo_no_es_urgente_por_defecto(): void
    {
        $this->post(route('equipos.store'), [
            'nombre' => 'Equipo normal',
            'tipo'   => 'Laptop',
            'estado' => 'disponible',
        ]);

        $equipo = Equipo::first();
        $this->assertFalse((bool) $equipo->urgente);
    }
}
