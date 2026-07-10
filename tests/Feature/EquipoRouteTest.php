<?php

namespace Tests\Feature;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoRouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function existe_la_ruta_equipos_index(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.index'));
    }

    /** @test */
    public function existe_la_ruta_equipos_create(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.create'));
    }

    /** @test */
    public function existe_la_ruta_equipos_store(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.store'));
    }

    /** @test */
    public function existe_la_ruta_equipos_edit(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.edit'));
    }

    /** @test */
    public function existe_la_ruta_equipos_update(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.update'));
    }

    /** @test */
    public function existe_la_ruta_equipos_destroy(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.destroy'));
    }

    /** @test */
    public function existe_la_ruta_equipos_urgente(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('equipos.urgente'));
    }

    /** @test */
    public function la_raiz_del_sitio_redirige_al_listado_de_equipos(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/equipos');
    }

    /** @test */
    public function una_ruta_que_no_existe_devuelve_404(): void
    {
        $response = $this->get('/esta-ruta-no-existe');

        $response->assertStatus(404);
    }
}
