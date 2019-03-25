<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchaseOrderBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_accept_valid_purchase_orders()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/po/create')
                ->assertSee('Buyer')
                ->assertSee('Supplier')
                ->assertSee('Total Cost')
                ->assertSee('Breakdown')
                ->assertSee('Purpose');

            $po = [
                'buyer'         => 'Ervinne Sodusta',
                'supplier'      => 'Jet Lighting LTD',
                'total_cost'    => 45000,
                'breakdown'     => 'Tube light Industrial 4w x 20, Tube light Industrial 7w x 15',
                'purpose'       => 'Replenishment'
            ];

            foreach($po as $field => $value) {
                $browser->type($field, $value);
            }

            $browser->press('Submit');
            $this->assertDatabaseHas('purchase_orders', $po);
        });
    }    
}