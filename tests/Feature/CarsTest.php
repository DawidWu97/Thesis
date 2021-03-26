<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CarsTest extends DuskTestCase
{
    public function testIndex()
    {
        $admin = User::find(2);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin);
            $browser->visit(route('admin.cars.index'));
            $browser->assertRouteIs('admin.cars.index');
        });
    }
}
