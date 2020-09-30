<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Test logging in when the user is not enabled.
     *
     * @return void
     */
    public function testLoginWhenNotEnabled()
    {
        $user = User::where('email', 'lekisha.dinatale@foo.com')->first();
        $user->is_enabled = false;
        $user->save();

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'lekisha.dinatale@foo.com')
                ->type('password', 'MFdqzRnhSb')
                ->press('LOGIN')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * Test successfull login.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'larhonda.hovis@foo.com')
                ->type('password', 'cghmpbKXXK')
                ->press('LOGIN')
                ->assertPathIs('/products');
        });
    }

    /**
     * Test login failure.
     *
     * @return void
     */
    public function testLoginFailure()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'larhonda.hovis@foo.com')
                ->type('password', 'incorrect')
                ->press('LOGIN')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * Test redirection from the home page to login.
     *
     * @return void
     */
    public function testRedirect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')->assertPathIs('/login');
        });
    }
}
