<?php

namespace Tests\Unit;

use App\Models\Animal;
use Tests\TestCase;

class AnimalTest extends TestCase
{
    public function test_create_animal()
    {
        $animal=new Animal(['category_id'=>5,
            'name'=>'Tedy',
            'breed'=>'persian',
            'gender'=>'male',
            'pedigree'=>'yes',
            'status'=>'giving_away',
            'birth_date'=>'2009-02-07',
            'color'=>'brown'
        ]);
        $this->assertEquals('Tedy',$animal->name);
        $this->assertNull($animal->weight);
        $this->assertNotEquals('no',$animal->pedigree);
    }

    public function test_value_type_create_animal()
    {
        $animal=new Animal(['category_id'=>5,
            'name'=>'Tedy',
            'breed'=>'persian',
            'gender'=>'male',
            'pedigree'=>'yes',
            'status'=>'giving_away',
            'birth_date'=>'3e3',
            'color'=>'brown'
        ]);
        $this->assertEquals('integer',gettype($animal->category_id));
        $this->assertEquals('string',gettype($animal->name));
    }

    public function test_animal_link()
    {
        $this->visit('animal')
            ->see('List of animals');
    }

    public function test_add_animal()
    {
        $this->withoutExceptionHandling();
        $this->visit('animal/create')
            ->see('Add your animal');
    }
}
