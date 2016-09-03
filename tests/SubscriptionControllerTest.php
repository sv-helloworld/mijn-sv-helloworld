<?php


class SubscriptionControllerTest extends TestCase
{
    /**
     * Tests whether a normal user can reach the subscription index.
     *
     * @return void
     */
    public function testSubscriptionIndex()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class)->create();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->seePageIs('/inschrijving')
             ->see('Inschrijvingen lidmaatschap');
    }

    /**
     * Tests whether a 'member' user can reach the subscription index.
     *
     * @return void
     */
    public function testSubscriptionIndexAsMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member')->create();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->seePageIs('/inschrijving')
             ->see('Inschrijvingen lidmaatschap');
    }

    /**
     * Tests whether a subscribed 'member' user can reach the subscription index.
     *
     * @return void
     */
    public function testSubscriptionIndexAsSubscribedMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member', 2)->create()->each(function ($u) {
            $u->subscriptions()->save(factory(App\Subscription::class, 'early_bird')->make());
        })->first();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->seePageIs('/inschrijving')
             ->see('Inschrijvingen lidmaatschap')
             ->dontSee('Je hebt je op dit moment nog nooit ingeschreven als lid.');
    }

    /**
     * Tests whether a subscribed 'member' user can reach the subscription detail page.
     *
     * @return void
     */
    public function testSubscriptionDetailAsSubscribedMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member', 2)->create()->each(function ($u) {
            $u->subscriptions()->save(factory(App\Subscription::class, 'early_bird')->make());
        })->first();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->click('Bekijken')
             ->see('Details inschrijving');
    }

    /**
     * Tests whether a 'member' user can visit the subscription form.
     *
     * @return void
     */
    public function testCreateSubscriptionAsMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member')->create();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->see('Je hebt je op dit moment nog nooit ingeschreven als lid.')
             ->dontSee('Je kunt je op dit moment nog niet inschrijven voor een nieuwe periode.')
             ->click('Inschrijven')
             ->see('Inschrijven als lid');
    }

    /**
     * Tests whether a 'member' user can subscribe without accepting the terms.
     *
     * @return void
     */
    public function testSubscribeMustAcceptTermsAsMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member')->create();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->click('Inschrijven')
             ->press('Inschrijven als lid')
             ->see('Je dient akkoord te gaan met de voorwaarden.');
    }

    /**
     * Tests whether a 'member' user can subscribe.
     *
     * @return void
     */
    public function testSubscribeAsMember()
    {
        $this->seed('TestingDatabaseSeeder');
        $member = factory(App\User::class, 'member')->create();

        $this->actingAs($member)
             ->visit('/inschrijving')
             ->click('Inschrijven')
             ->check('accept')
             ->press('Inschrijven als lid')
             ->see('Je hebt je succesvol ingeschreven als lid');
    }
}
