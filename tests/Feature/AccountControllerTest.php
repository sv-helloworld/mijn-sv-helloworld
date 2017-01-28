<?php

namespace Tests\Feature;

use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    /**
     * Tests if a logged in user can reach the account index.
     *
     * @return void
     */
    public function testAccountIndex()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
             ->visit('/account')
             ->see('Account');
    }

    /**
     * Tests if the user can edit his account.
     *
     * @return void
     */
    public function testCanEditAccount()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
             ->visit('/account/bewerken')
             ->see('Account wijzigen')
             ->type('Testvoornaam', 'first_name')
             ->press('Account wijzigen')
             ->seePageIs('/account')
             ->see('Je gegevens zijn bijgewerkt!')
             ->see('Testvoornaam');
    }

    /**
     * Tests if the user can edit his email address.
     *
     * @return void
     */
    public function testCanEditEmail()
    {
        $user = factory(App\User::class)->create([
            'email' => 'abc@hz.nl',
        ]);

        $this->actingAs($user)
             ->visit('/account/email/bewerken')
             ->see('E-mailadres wijzigen')
             ->type('xyz@hz.nl', 'email')
             ->type('xyz@hz.nl', 'email_confirmation')
             ->press('E-mailadres wijzigen')
             ->seePageIs('/account')
             ->see('Je e-mailadres is bijgewerkt.')
             ->see('xyz@hz.nl')
             ->dontSee('abc@hz.nl')
             ->seeInDatabase('users', ['id' => $user->id, 'email' => 'xyz@hz.nl'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'email' => 'abc@hz.nl']);
    }

    /**
     * Tests if the user needs to validate his email address after changing it.
     *
     * @return void
     */
    public function testMustVerifyEmailAfterEditEmail()
    {
        $user = factory(App\User::class)->create([
            'email' => 'abc@hz.nl',
        ]);

        $this->actingAs($user)
            ->visit('/account/email/bewerken')
            ->see('E-mailadres wijzigen')
            ->type('verify@hz.nl', 'email')
            ->type('verify@hz.nl', 'email_confirmation')
            ->press('E-mailadres wijzigen')
            ->seePageIs('/account')
            ->see('Je e-mailadres is bijgewerkt.')
            ->see('verify@hz.nl')
            ->dontSee('abc@hz.nl')
            ->seeInDatabase('users', ['id' => $user->id, 'email' => 'verify@hz.nl', 'verified' => false])
            ->dontSeeInDatabase('users', ['id' => $user->id, 'email' => $user->email, 'verified' => true]);
    }

    /**
     * Tests if the user can edit his email address when supplying
     * two different email addresses.
     *
     * @return void
     */
    public function testCantEditWithWrongEmail()
    {
        $user = factory(App\User::class)->create([
            'email' => 'abc@hz.nl',
        ]);

        $this->actingAs($user)
             ->visit('/account/email/bewerken')
             ->see('E-mailadres wijzigen')
             ->type('test@hz.nl', 'email')
             ->type('test2@hz.nl', 'email_confirmation')
             ->press('E-mailadres wijzigen')
             ->seePageIs('/account/email/bewerken')
             ->see('email bevestiging komt niet overeen.')
             ->notSeeInDatabase('users', ['id' => $user->id, 'email' => 'test@hz.nl']);
    }

    /**
     * Tests if the user can change his password.
     *
     * @return void
     */
    public function testCanChangePassword()
    {
        $user = factory(App\User::class)->create([
            'password' => bcrypt('CurrentPassword123'),
        ]);

        $this->actingAs($user)
             ->visit('/account/wachtwoord/bewerken')
             ->see('Wachtwoord wijzigen')
             ->type('CurrentPassword123', 'password_current')
             ->type('NewPassword123', 'password')
             ->type('NewPassword123', 'password_confirmation')
             ->press('Wachtwoord wijzigen')
             ->seePageIs('/account')
             ->see('Je wachtwoord is bijgewerkt.');
    }

    /**
     * Tests if the user can change his password with wrong current password.
     *
     * @return void
     */
    public function testCantChangePasswordWithWrongCurrentPassword()
    {
        $user = factory(App\User::class)->create([
            'password' => 'CurrentPassword123',
        ]);

        $this->actingAs($user)
             ->visit('/account/wachtwoord/bewerken')
             ->see('Wachtwoord wijzigen')
             ->type('WrongCurrentPassword123', 'password_current')
             ->type('NewPassword123', 'password')
             ->type('NewPassword123', 'password_confirmation')
             ->press('Wachtwoord wijzigen')
             ->seePageIs('/account/wachtwoord/bewerken')
             ->see('huidige wachtwoord is onjuist.');
    }

    /**
     * Tests if the user can change his password with different new passwords.
     *
     * @return void
     */
    public function testCantChangePasswordWithDifferentPasswords()
    {
        $user = factory(App\User::class)->create([
            'password' => 'CurrentPassword123',
        ]);

        $this->actingAs($user)
             ->visit('/account/wachtwoord/bewerken')
             ->see('Wachtwoord wijzigen')
             ->type('CurrentPassword123', 'password_current')
             ->type('NewPassword123', 'password')
             ->type('WrongNewPassword123', 'password_confirmation')
             ->press('Wachtwoord wijzigen')
             ->seePageIs('/account/wachtwoord/bewerken')
             ->see('password bevestiging komt niet overeen.');
    }

    /**
     * Tests if the user can reach the account page when not logged in.
     *
     * @return void
     */
    public function testCantReachAccountIndexWhenNotLoggedIn()
    {
        $this->visit('/account')
             ->seePageIs('/inloggen')
             ->see('Inloggen');
    }

    /**
     * Tests if the user can reach the password change page when not logged in.
     *
     * @return void
     */
    public function testCantReachPasswordEditPageWhenNotLoggedIn()
    {
        $this->visit('/account/wachtwoord/bewerken')
             ->seePageIs('/inloggen')
             ->see('Inloggen');
    }

    /**
     * Tests if the user can reach the email address change page when not logged in.
     *
     * @return void
     */
    public function testCantReachEmailEditPageWhenNotLoggedIn()
    {
        $this->visit('/account/wachtwoord/bewerken')
             ->seePageIs('/inloggen')
             ->see('Inloggen');
    }

    /**
     * Tests if the user can reach the index page when the user is deactivated.
     *
     * @return void
     */
    public function testCantReachIndexPageWhenNotActivated()
    {
        $user = factory(App\User::class)->create([
            'activated' => false,
        ]);

        $this->actingAs($user)
             ->visit('/')
             ->see('Account gedeactiveerd')
             ->seePageIs('/account/gedeactiveerd');
    }
}
