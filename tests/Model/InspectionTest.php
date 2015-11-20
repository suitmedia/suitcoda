<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Inspection;

class InspectionTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetStatusAttribute()
    {
        $inspection = new Inspection;

        $listStat = [
            -1 => 'Unknown',
            0 => 'Queue',
            1 => 'Process',
            2 => 'Completed'
        ];

        foreach ($listStat as $key => $value) {
            $inspection->status = $key;
            $this->assertEquals($value, $inspection->stat);
        }
    }

    public function testRelationshipWithProject()
    {
        $inspection = new Inspection;

        $this->assertInstanceOf(BelongsTo::class, $inspection->project());
    }

    public function testScopeGetById()
    {
        $inspection = new Inspection;

        $this->assertEquals(new Collection, $inspection->getById(1));
    }
}
