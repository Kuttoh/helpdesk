<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Ticket;
use App\TicketType;
use App\Reply;
use App\Role;
use App\TicketStatus;
use App\TicketAssignee;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'role_id' => function () {
            factory(Role::class)->create()->id;
        },
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Ticket::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'ticket_type_id' => function () {
            return factory(TicketType::class)->create()->id;
        },
        'ticket_status_id' => function () {
            return factory(TicketStatus::class)->create()->id;
        },
        'subject' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});

$factory->define(TicketType::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(Reply::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'ticket_id' => function () {
            return factory(Ticket::class)->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});

$factory->define(Role::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
    ];
});

$factory->define(TicketStatus::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
    ];
});

$factory->define(TicketAssignee::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'ticket_id' => function () {
            return factory(Ticket::class)->create()->id;
        },
    ];
});


