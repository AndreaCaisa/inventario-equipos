<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_tabla_equipos_existe(): void
    {
        $this->assertTrue(Schema::hasTable('equipos'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_nombre(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'nombre'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_tipo(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'tipo'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_marca(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'marca'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_estado(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'estado'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_ubicacion(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'ubicacion'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_la_columna_urgente(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'urgente'));
    }

    /** @test */
    public function la_tabla_equipos_tiene_timestamps(): void
    {
        $this->assertTrue(Schema::hasColumn('equipos', 'created_at'));
        $this->assertTrue(Schema::hasColumn('equipos', 'updated_at'));
    }
}
