<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageTicketTypesTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo;
    protected $userRepo;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    public function testNormalUserCannotViewTicketTypes()
    {
        $this->signIn();

        $response = $this->get('/ticketTypes');

        $response->assertRedirect('/tickets')
            ->assertDontSee('Ticket Types');
    }

    public function testOnlyEngineersCanViewTicketTypes()
    {
        $user = factory(User::class)->create([
            'role_id' => 2
        ]);

        $this->signIn($user);

        $response = $this->get('/ticketTypes');

        $response->assertSuccessful()
            ->assertSee('Ticket Types');
    }
}
