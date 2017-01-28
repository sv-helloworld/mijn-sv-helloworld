<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Tests if an normal user can reach the user management index.
     *
     * @return void
     */
    public function testUserIndexAsNormalUser()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
             ->visit('/')
             ->visit('/gebruikers')
             ->see('Welkom')
             ->seePageIs('/');
    }

    /**
     * Tests if an admin can reach the user management index.
     *
     * @return void
     */
    public function testUserIndexAsAdmin()
    {
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers')
             ->see('Gebruikers');
    }

    /**
     * Tests if an admin can't deactivate his own account.
     *
     * @return void
     */
    public function testAdminCantDeactivateHisOwnAccount()
    {
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$admin->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('0', 'activated')
             ->press('Gebruiker wijzigen')
             ->see('het is niet toegestaan jezelf te deactiveren.')
             ->dontSee('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$admin->id.'/edit')
             ->notSeeInDatabase('users', ['id' => $admin->id, 'activated' => 0]);
    }

    /**
     * Tests if an admin can't change the account type of his own account.
     *
     * @return void
     */
    public function testAdminCantChangeRoleOfHisOwnAccount()
    {
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$admin->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('user', 'account_type')
             ->press('Gebruiker wijzigen')
             ->see('het is niet toegestaan om je eigen account type te wijzigen.')
             ->dontSee('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$admin->id.'/edit')
             ->notSeeInDatabase('users', ['id' => $admin->id, 'account_type' => 'user']);
    }

    /**
     * Tests if an admin can change the name of a user.
     *
     * @return void
     */
    public function testAdminCanChangeUserName()
    {
        $user = factory(App\User::class)->create([
            'first_name' => 'Oude Naam',
        ]);
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->type('Nieuwe Naam', 'first_name')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'first_name' => 'Nieuwe Naam'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'first_name' => 'Oude Naam']);
    }

    /**
     * Tests if an admin can change the email of a user.
     *
     * @return void
     */
    public function testAdminCanChangeUserEmail()
    {
        $user = factory(App\User::class)->create([
            'email' => 'oud123@hz.nl',
        ]);
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->type('nieuw123@hz.nl', 'email')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'email' => 'nieuw123@hz.nl'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'email' => 'oud123@hz.nl']);
    }

    /**
     * Tests if an admin can change the email of a user.
     *
     * @return void
     */
    public function testUserMustVerifyEmailAfterEmailEdit()
    {
        $user = factory(App\User::class)->create();
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
            ->visit('/gebruikers/'.$user->id.'/edit')
            ->see('Wijzig gebruiker')
            ->type('nieuw123@hz.nl', 'email')
            ->press('Gebruiker wijzigen')
            ->see('Gebruiker bijgewerkt.')
            ->seePageIs('/gebruikers/'.$user->id)
            ->seeInDatabase('users', ['id' => $user->id, 'email' => 'nieuw123@hz.nl', 'verified' => false])
            ->dontSeeInDatabase('users', ['id' => $user->id, 'email' => $user->email, 'verified' => true]);
    }

    /**
     * Tests if an admin can deactivate an user via the edit view.
     *
     * @return void
     */
    public function testAdminCanDeactivateUseViaEditView()
    {
        $user = factory(App\User::class)->create();
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('0', 'activated')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'activated' => '0'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'activated' => '1']);
    }

    /**
     * Tests if an admin can activate an user via the edit view.
     *
     * @return void
     */
    public function testAdminCanActivateUseViaEditView()
    {
        $user = factory(App\User::class)->create([
            'activated' => 0,
        ]);
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('1', 'activated')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'activated' => '1'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'activated' => '0']);
    }

    /**
     * Tests if an admin can change the account type of a user to admin.
     *
     * @return void
     */
    public function testAdminCanChangeUserRoleToAdmin()
    {
        $user = factory(App\User::class)->create();
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('admin', 'account_type')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'account_type' => 'admin']);
    }

    /**
     * Tests if an admin can change the account type of a user to user.
     *
     * @return void
     */
    public function testAdminCanChangeUserRoleToUser()
    {
        $user = factory(App\User::class)->create();
        $admin = factory(App\User::class, 'admin')->create();

        $this->actingAs($admin)
             ->visit('/gebruikers/'.$user->id.'/edit')
             ->see('Wijzig gebruiker')
             ->select('user', 'account_type')
             ->press('Gebruiker wijzigen')
             ->see('Gebruiker bijgewerkt.')
             ->seePageIs('/gebruikers/'.$user->id)
             ->seeInDatabase('users', ['id' => $user->id, 'account_type' => 'user']);
    }
}
