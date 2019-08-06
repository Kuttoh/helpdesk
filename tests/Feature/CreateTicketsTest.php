<?php

namespace Tests\Feature;

use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Role;
use App\Ticket;
use App\TicketStatus;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTicketsTest extends TestCase
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

//    public function testbg()
//    {
//        $this->withExceptionHandling();
//
//        $this->signIn();
//
//        $response = $this->get('/ticketTypes');
//
//        $response->assertRedirect('/tickets');
//    }

//    public function testUserCanCreateTicket()
//    {
//        $user = $this->signIn();
//
//        $data = [
//            'user_id' => null,
//            'ticket_type_id' => null,
//            'ticket_status_id' => null,
//            'subject' => 'test',
//            'body' => 'test body',
//            'assigned_to' => null,
//        ];
//
//        $this->ticketRepo->save($data);
//
//         $this->assertDatabaseHas('tickets', $data);
//    }

//    public function testCanGetUserById()
//    {
//        $user = $this->signIn();
//
//        $other = $this->userRepo->getUserById($user->id);
//
//        $this->assertEquals($user->firstname, $other->firstname);
//    }


//    public function testAuthorizedUserCanCreateTickets()
//    {
//        $this->role = factory(Role::class)->create();
//
//        $user = factory(User::class)->create(['role_id' => $this->role]);
//
//        $this->signIn($user);
//
//        $ticketType = factory(TicketType::class)->create();
//
//        $ticketStatus = factory(TicketStatus::class)->create();
//
//        $addedTicket = factory(Ticket::class)->create([
//            'user_id' => $user->id,
//            'ticket_status_id' => $ticketStatus->id,
//            'ticket_type_id' => $ticketType->id,
//            'assigned_to' => null
//        ]);
//
//        $tickets = $this->ticketRepo->save($addedTicket->toArray());
//
//        $this->assertDatabaseHas('tickets', $tickets);
//    }
}
