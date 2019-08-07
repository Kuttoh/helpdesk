<?php

namespace Tests\Unit;

use App\Repositories\ReplyRepository;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RepliesTest extends TestCase
{
    use DatabaseTransactions;

    protected $replyRepo;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->replyRepo = new ReplyRepository();

        $this->faker = Factory::create();
    }

    public function testItCanSaveAReply()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $anotherUser = factory(User::class)->create();

        $ticket = factory(Ticket::class)->create([
            'assigned_to' => $anotherUser->id
        ]);

        $comment = [
            'body' => $this->faker->sentence,
            'ticket_id' => $ticket->id
        ];

        $this->replyRepo->save($comment);

        $this->assertDatabaseHas('replies', [
            'body' => $comment['body']
        ]);
    }
}
