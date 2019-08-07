<?php

namespace Tests\Feature;

use App\Reply;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageRepliesTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->faker = Factory::create();
    }

    public function testUnauthenticatedUserCannotViewTicketReplies()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->get('/tickets/'. $ticket->id);

        $response->assertRedirect('/login');
    }

    public function testUserCanReplyToATicket()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $ticket = factory(Ticket::class)->create([
            'user_id' => $user->id,
        ]);

        $comment = factory(Reply::class)->create([
            'body' => $this->faker->sentence,
            'ticket_id' => $ticket->id
        ]);

        $response = $this->get('/tickets/' . $ticket->id);

        $response->assertSeeText($comment['body']);
    }
}
