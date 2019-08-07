<?php

namespace Tests\Feature;

use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageTicketsTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo;
    protected $userRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->ticketRepo = new TicketRepository();
        $this->userRepo = new UserRepository();
    }

    public function testGuestsCannotViewTickets()
    {
        $this->withExceptionHandling();

        $response = $this->get('/tickets');

        $response->assertRedirect('/login');
    }

    public function testGuestsCannotCreateTickets()
    {
        $this->withExceptionHandling();

        $response = $this->get('/tickets/create');

        $response->assertRedirect('/login');
    }

    public function testAuthorizedUserCanViewTicketsPage()
    {
        $this->signIn();

        $response = $this->get('/tickets');

        $response->assertSee('Tickets');
    }

    public function testAuthorizedUserCanCreateTicket()
    {
        $this->signIn();

        $ticketData = factory(Ticket::class)->create();

        $this->ticketRepo->save($ticketData->toArray());

        $this->assertDatabaseHas('tickets', [
            'user_id' => $ticketData->user_id
        ]);
    }

    public function testAuthorizedUserCanViewTicketsTheyCreated()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $ticketData = factory(Ticket::class)->create([
            'user_id' => $user->id
        ]);

        $this->ticketRepo->orderedTickets();

        $response = $this->get('tickets');

        $response->assertSee($ticketData->creator->firstname)
            ->assertSee($ticketData->type->name)
            ->assertSee($ticketData->created_at);
    }
}
