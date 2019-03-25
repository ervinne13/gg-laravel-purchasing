<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PurchaseOrderIndexPage;
use Tests\DuskTestCase;

class PurchaseOrderBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_accept_valid_purchase_orders_and_display_results()
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

            $browser
                ->press('Submit')
                ->on(new PurchaseOrderIndexPage())
                ->with('.table', function($table) use ($po) {
                    $table
                        ->assertSee($po['buyer'])
                        ->assertSee('View')
                        ->assertSee('Edit')
                        ->assertSee('Delete');
                });
        });
    }      
}