<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_accept_valid_purchase_orders()
    {
        $po = [
            'buyer'         => 'Ervinne Sodusta',
            'supplier'      => 'Jet Lighting LTD',
            'total_cost'    => 45000,
            'breakdown'     => 'Tube light Industrial 4w x 20, Tube light Industrial 7w x 15',
            'purpose'       => 'Replenishment'
        ];
        $response = $this->json('POST', '/po', $po);
        $response->assertRedirect('/po');
        $this->assertDatabaseHas('purchase_orders', $po);
    }
}