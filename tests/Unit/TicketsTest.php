<?php

namespace Tests\Unit;

use App\Repositories\TicketRepository;
use App\TicketType;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use DatabaseTransactions;

    protected $ticketRepo;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->ticketRepo = new TicketRepository();

        $this->faker = Factory::create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCanSaveTicket()
    {
        $this->signIn();

        $type = factory(TicketType::class)->create();

        $input = [
            'ticket_type_id' => $type->id,
            'subject' => $this->faker->word,
            'body' => $this->faker->sentence
        ];

        $this->ticketRepo->save($input);

        $this->assertDatabaseHas('tickets', [
            'subject' => $input['subject']
        ]);
    }
}
