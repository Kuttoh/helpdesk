<?php

namespace Tests\Feature;

use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageTicketsTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo;
    protected $userRepo;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->ticketRepo = new TicketRepository();

        $this->userRepo = new UserRepository();

        $this->faker = Factory::create();
    }

    public function testGuestsCannotViewTickets()
    {
        $response = $this->get('/tickets');

        $response->assertRedirect('/login');
    }

    public function testGuestsCannotCreateTickets()
    {
        $response = $this->get('/tickets/create');

        $response->assertRedirect('/login');
    }

    public function testLoggedInUserCanViewTicketsPage()
    {
        $this->signIn();

        $response = $this->get('/tickets');

        $response->assertSee('Tickets');
    }

    public function testAuthorizedUserCanViewTicketsTheyCreated()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $ticketData = factory(Ticket::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('tickets');

        $response->assertSee($ticketData->creator->firstname)
            ->assertSee($ticketData->type->name)
            ->assertSee($ticketData->created_at);
    }

    public function testUnauthorizedUsersAreRedirectedToTicketsPage()
    {
        $user = factory(User::class)->create();

        $this->signIn();

        $ticketData = factory(Ticket::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('tickets/'. $ticketData->id);

        $response->assertRedirect('/tickets');
    }
}
