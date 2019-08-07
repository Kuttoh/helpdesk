<?php

namespace Tests\Unit;

use App\Repositories\TicketRepository;
use App\TicketType;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketStatusTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo, $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->ticketRepo = new TicketRepository();

        $this->faker = Factory::create();

        $this->type = factory(TicketType::class)->create();
    }

    public function testATicketCreatedIsOpenByDefault()
    {
        $this->signIn();

        $input = [
            'ticket_type_id' => $this->type->id,
            'subject' => $this->faker->word,
            'body' => $this->faker->sentence
        ];

        $ticket = $this->ticketRepo->save($input);

        $this->assertEquals($ticket['ticket_status_id'], 1);
    }
}
