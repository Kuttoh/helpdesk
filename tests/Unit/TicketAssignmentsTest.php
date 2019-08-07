<?php

namespace Tests\Unit;

use App\Repositories\TicketRepository;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketAssignmentsTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->ticketRepo = new TicketRepository();

    }

    public function testNonEngineersCannotAssignTicket()
    {
        $this->signIn();

        $ticket = (factory(Ticket::class)->create())->toArray();

        $this->ticketRepo->postAssign($ticket, $ticket['id']);

        $this->assertDatabaseMissing('tickets', [
            'assigned_to' => $ticket['user_id']
        ]);
    }

    public function testUserCannotBeAssignedTicketTheyCreated()
    {
        $user = factory(User::class)->create([
            'role_id' => 2
        ]);

        $this->signIn($user);

        $ticket = factory(Ticket::class)->create();

        $this->ticketRepo->postAssign($ticket, $ticket['id']);

        $this->assertDatabaseMissing('tickets', [
            'assigned_to' => $ticket['user_id']
        ]);
    }

    public function testEngineerCannotTakeupTicketTheyCreated()
    {
        $user = factory(User::class)->create([
            'role_id' => 2
        ]);

        $this->signIn($user);

        $ticket = (factory(Ticket::class)->create([
            'user_id' => $user->id
        ]))->toArray();

        $this->ticketRepo->postTake($ticket['id']);

        $this->assertDatabaseMissing('tickets', [
            'assigned_to' => $ticket['user_id']
        ]);
    }
}
