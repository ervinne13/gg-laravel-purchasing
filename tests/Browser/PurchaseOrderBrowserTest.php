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
    public function it_can_view_created_purchase_orders()
    {
        $poList = factory(PurchaseOrder::class, 5)->create();
        
        $this->browse(function (Browser $browser) use ($poList) {
            foreach($poList as $po) {
                $totalCostDisplay = 'P' . number_format($po->total_cost);

                $browser
                    ->visit("/po/{$po->id}")
                    ->assertSee($po->buyer)
                    ->assertSee($po->supplier)
                    ->assertSee($totalCostDisplay)
                    ->assertSee($po->breakdown)
                    ->assertSee($po->purpose);
            }
        });
    }

    /** @test */
    public function it_redirects_purchase_order_on_clicking_view_on_index()
    {
        $poList = factory(PurchaseOrder::class, 5)->create();

        $this->browse(function (Browser $browser) use ($poList) {
            foreach($poList as $po) {

                $actionLinkSelector = "[action='view-po'][data-id='{$po->id}']";
                $browser
                    ->visit('/po')
                    ->click($actionLinkSelector)
                    ->assertUrlIs(url("/po/{$po->id}"));
            }
        });
    }

    /** @test */
    public function it_redirects_purchase_order_on_clicking_edit_on_index()
    {
        $poList = factory(PurchaseOrder::class, 5)->create();

        $this->browse(function (Browser $browser) use ($poList) {
            foreach($poList as $po) {

                $actionLinkSelector = "[action='edit-po'][data-id='{$po->id}']";
                $browser
                    ->visit('/po')
                    ->click($actionLinkSelector)
                    ->assertUrlIs(url("/po/{$po->id}/edit"));
            }
        });
    }

    /** @test */
    public function it_can_accept_valid_purchase_orders_and_display_results()
    {
        $this->browse(function (Browser $browser) {
            $po = $this->getPurchaseOrderStub();

            $browser->visit('/po/create');
            $this->assertFormViewContainsCorrectLabelsWith($browser);
            $this->typeInPurchaseOrderToFieldsTo($browser, $po);
            $this->assertSavedPurchaseOrderDisplaysResultsOnSubmitWith($browser, $po);
        });
    }

    /** @test */
    public function it_can_update_purchase_orders_with_valid_input_and_display_results()
    {
        $createdPoList = factory(PurchaseOrder::class, 1)->create();
        $po = $createdPoList[0];

        $this->browse(function (Browser $browser) use ($po) {
            $updatedPo = $this->getPurchaseOrderStub();

            $browser->visit("/po/{$po->id}/edit");
            $this->assertFormViewContainsCorrectLabelsWith($browser);
            $this->typeInPurchaseOrderToFieldsTo($browser, $updatedPo);
            $this->assertSavedPurchaseOrderDisplaysResultsOnSubmitWith($browser, $updatedPo);
        });
    }

    private function assertFormViewContainsCorrectLabelsWith($browser) : void
    {
        $browser
            ->assertSee('Buyer')
            ->assertSee('Supplier')
            ->assertSee('Total Cost')
            ->assertSee('Breakdown')
            ->assertSee('Purpose');
    }

    private function getPurchaseOrderStub() : array
    {
        return [
            'buyer'         => 'Ervinne Sodusta',
            'supplier'      => 'Jet Lighting LTD',
            'total_cost'    => '45000.00',
            'breakdown'     => 'Tube light Industrial 4w x 20, Tube light Industrial 7w x 15',
            'purpose'       => 'Replenishment'
        ];
    }

    private function typeInPurchaseOrderToFieldsTo($browser, array $po) : void
    {
        foreach($po as $field => $value) {
            $browser->type($field, trim($value));
        }
    }

    private function assertSavedPurchaseOrderDisplaysResultsOnSubmitWith($browser, array $po) : void
    {
        $browser
            ->press('Submit')
            ->on(new PurchaseOrderIndexPage());
            
        $this->assertSeePurchaseOrderRowOn($browser, $po);
    }

    /** @test */
    public function it_can_delete_purchase_orders()
    {
        $createdPoList = factory(PurchaseOrder::class, 1)->create();
        $po = $createdPoList[0];

        $this->browse(function (Browser $browser) use ($po) {        
            $actionLinkSelector = "[action='delete-po'][data-id='{$po->id}']";
            $browser->visit('/po');
            $this->assertSeePurchaseOrderRowOn($browser, $po);

            $browser
                ->click($actionLinkSelector)
                ->waitForReload()
                ->assertUrlIs(url("/po"));

            $this->assertDontSeePurchaseOrderRowOn($browser, $po);
        });
    }

    private function assertSeePurchaseOrderRowOn($browser, $po)
    {
        $browser
            ->with('.table', function($table) use ($po) {
                $table
                    ->assertSee($po['buyer'])
                    ->assertSee($po['supplier'])
                    ->assertSee($po['purpose']);
            });
    }

    private function assertDontSeePurchaseOrderRowOn($browser, $po)
    {
        $browser
            ->with('.table', function($table) use ($po) {
                $table
                    ->assertDontSee($po['buyer'])
                    ->assertDontSee($po['supplier'])
                    ->assertDontSee($po['purpose']);
            });
    }
}