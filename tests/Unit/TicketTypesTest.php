<?php

namespace Tests\Unit;

use App\Repositories\TicketTypeRepository;
use App\TicketType;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketTypesTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker, $ticketTypeRepo, $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->ticketTypeRepo = new TicketTypeRepository();

        $this->user = factory(User::class)->create([
            'role_id' => 2
        ]);
    }

    public function testItCanSaveTicketType()
    {
        $this->signIn($this->user);

        $input = [
            'name' => 'test'
        ];

        $this->ticketTypeRepo->save($input);

        $this->assertDatabaseHas('ticket_types', [
            'name' => $input['name']
        ]);
    }

    public function testItCanEditTicketType()
    {
        $this->signIn($this->user);

        $oldType = factory(TicketType::class)->create([
            'name' => 'nothing close'
        ]);

        $input = [
            'name' => 'wamlambez'
        ];

        $this->ticketTypeRepo->update($input, $oldType->id);

        $this->assertDatabaseHas('ticket_types', [
            'name' => $input['name']
        ]);
    }

    public function testItCanDeleteTicketType()
    {
        $this->signIn($this->user);

        $type = factory(TicketType::class)->create();

        $this->ticketTypeRepo->delete($type->id);

        $this->assertDatabaseMissing('ticket_types', [
            'id' => $type->id
        ]);
    }
}
