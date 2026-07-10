<?php

namespace Tests\Unit;

use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipoModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function el_modelo_usa_la_tabla_equipos(): void
    {
        $equipo = new Equipo();
        $this->assertEquals('equipos', $equipo->getTable());
    }

    /** @test */
    public function tiene_los_campos_fillable_correctos(): void
    {
        $equipo = new Equipo();
        $esperado = ['nombre', 'tipo', 'marca', 'estado', 'ubicacion', 'urgente'];

        foreach ($esperado as $campo) {
            $this->assertContains($campo, $equipo->getFillable());
        }
    }

    /** @test */
    public function puede_crearse_con_mass_assignment(): void
    {
        $equipo = Equipo::create([
            'nombre'    => 'Laptop Dell 05',
            'tipo'      => 'Laptop',
            'marca'     => 'Dell',
            'estado'    => 'disponible',
            'ubicacion' => 'Laboratorio 1',
        ]);

        $this->assertInstanceOf(Equipo::class, $equipo);
        $this->assertDatabaseHas('equipos', ['nombre' => 'Laptop Dell 05']);
    }

    /** @test */
    public function el_campo_urgente_se_castea_a_booleano(): void
    {
        $equipo = Equipo::factory()->create(['urgente' => 1]);

        $this->assertIsBool($equipo->urgente);
        $this->assertTrue($equipo->urgente);
    }

    /** @test */
    public function el_campo_urgente_por_defecto_es_falso(): void
    {
        $equipo = Equipo::factory()->create();

        $this->assertFalse((bool) $equipo->urgente);
    }

    /** @test */
    public function el_factory_genera_un_equipo_valido(): void
    {
        $equipo = Equipo::factory()->create();

        $this->assertNotEmpty($equipo->nombre);
        $this->assertNotEmpty($equipo->tipo);
        $this->assertContains($equipo->estado, ['disponible', 'en_uso', 'mantenimiento']);
    }

    /** @test */
    public function el_factory_puede_generar_varios_equipos(): void
    {
        Equipo::factory()->count(10)->create();

        $this->assertDatabaseCount('equipos', 10);
    }

    /** @test */
    public function un_equipo_se_puede_actualizar(): void
    {
        $equipo = Equipo::factory()->create(['nombre' => 'Original']);
        $equipo->update(['nombre' => 'Actualizado']);

        $this->assertEquals('Actualizado', $equipo->fresh()->nombre);
    }

    /** @test */
    public function un_equipo_se_puede_eliminar(): void
    {
        $equipo = Equipo::factory()->create();
        $id = $equipo->id;

        $equipo->delete();

        $this->assertDatabaseMissing('equipos', ['id' => $id]);
    }

    /** @test */
    public function el_equipo_tiene_marcas_de_tiempo(): void
    {
        $equipo = Equipo::factory()->create();

        $this->assertNotNull($equipo->created_at);
        $this->assertNotNull($equipo->updated_at);
    }

    /** @test */
    public function el_estado_acepta_disponible(): void
    {
        $equipo = Equipo::factory()->create(['estado' => 'disponible']);
        $this->assertEquals('disponible', $equipo->estado);
    }

    /** @test */
    public function el_estado_acepta_mantenimiento(): void
    {
        $equipo = Equipo::factory()->create(['estado' => 'mantenimiento']);
        $this->assertEquals('mantenimiento', $equipo->estado);
    }
}
