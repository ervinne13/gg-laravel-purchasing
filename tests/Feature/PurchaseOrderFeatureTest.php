<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $userList = factory(User::class, 1)->create();
        $user = $userList[0];

        $response = $this->actingAs($user)->json('POST', '/po', $po);
        $response->assertRedirect('/po');
        $this->assertDatabaseHas('purchase_orders', $po);
    }
}