<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\PurchaseOrder;
use Tests\Browser\Pages\PurchaseOrderIndexPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

    /** @test */
    public function it_can_view_created_purchase_orders()
    {
        $poList = factory(PurchaseOrder::class, 10)->create();
        
        $this->browse(function (Browser $browser) use ($poList) {
            foreach($poList as $po) {
                $browser
                    ->visit("/po/{$po->id}")
                    ->assertSee($po->buyer)
                    ->assertSee($po->supplier)
                    ->assertSee($po->total_cost)
                    ->assertSee($po->breakdown)
                    ->assertSee($po->purpose);
            }
        });        
    }
}