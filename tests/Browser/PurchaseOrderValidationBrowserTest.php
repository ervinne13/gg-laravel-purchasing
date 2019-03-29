<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PurchaseOrderIndexPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseOrderValidationBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_validate_missing_fields()
    {
        $this->browse(function (Browser $browser) {
            $userList = factory(User::class, 1)->create();
            $user = $userList[0];

            $browser
                ->loginAs($user)
                ->visit('/po/create')
                ->press('Submit')
                ->assertSee('The supplier field is required')
                ->assertSee('The total cost field is required')
                ->assertSee('The breakdown field is required')
                ->assertSee('The purpose field is required');
        });
    }
}
