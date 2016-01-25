<?php

namespace SuitTests\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SuitTests\TestCase;
use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Score;

class ScoreTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test Relationship Score with Inspection
     *
     * @return void
     */
    public function testRelationshipWithInspection()
    {
        $score = new Score;

        $this->assertInstanceOf(BelongsTo::class, $score->inspection());
    }

    /**
     * Test Relationship Score with Category
     *
     * @return void
     */
    public function testRelationshipWithCategory()
    {
        $score = new Score;

        $this->assertInstanceOf(BelongsTo::class, $score->category());
    }

    /**
     * Test get query score of byCategoryName method
     *
     * @return void
     */
    public function testScopeByCategoryName()
    {
        $score = new Score;

        $this->assertInstanceOf(Collection::class, $score->byCategoryName(1)->get());
    }

    /**
     * Test get query score of byCategorySlug method
     *
     * @return void
     */
    public function testScopeByCategorySlug()
    {
        $score = new Score;

        $this->assertInstanceOf(Collection::class, $score->byCategorySlug(1)->get());
    }

    /**
     * Test get query score of byRelatedId method
     *
     * @return void
     */
    public function testScopeByRelatedId()
    {
        $score = new Score;

        $this->assertInstanceOf(Collection::class, $score->byRelatedId(1, 1)->get());
    }

    /**
     * Test get query score of findOrNewByRelatedId method
     *
     * @return void
     */
    public function testScopeFindOrNewByRelatedId()
    {
        $score = new Score;

        $this->assertInstanceOf(Score::class, $score->findOrNewByRelatedId(1, 1));

        $inspectionFaker = factory(Inspection::class)->create();
        $categoryFaker = factory(Category::class)->create();
        factory(Score::class)->create([
            'inspection_id' => $inspectionFaker->id,
            'category_id' => $categoryFaker->id,
        ]);

        $this->assertInstanceOf(Score::class, $score->findOrNewByRelatedId($inspectionFaker->id, $categoryFaker->id));
    }

    public function testGetScoreAttribute()
    {
        $scoreFaker = factory(Score::class)->create([
            'score' => 0.7
        ]);
        $this->assertEquals(70, $scoreFaker->score);
    }
}
