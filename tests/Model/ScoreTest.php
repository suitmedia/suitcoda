<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suitcoda\Model\Score;
use SuitTests\TestCase;

class ScoreTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Score with Project
     *
     * @return void
     */
    public function testRelationshipWithProject()
    {
        $score = new Score;

        $this->assertInstanceOf(BelongsTo::class, $score->inspection());
    }
}
