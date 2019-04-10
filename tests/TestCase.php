<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
use App\User;
use App\Team;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;
    protected $faker;

    /**
     * Set up the test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->faker = Faker::create();
    }

    /**
     * Reset the migrations.
     */
    protected function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }

    public function seed($class = 'DatabaseSeeder')
    {
        $this->artisan('db:seed', ['--class' => $class]);

        return $this;
    }

    public function createUserTeam()
    {
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create();

        return array($user, $team);
    }

    public function createUsersTeam($user_number = 10)
    {
        $users = factory(User::class, $user_number)->create();
        $team = factory(Team::class)->create();

        return array($users, $team);
    }

    public function createUserTeams($team_number = 10)
    {
        $user = factory(User::class)->create();
        $teams = factory(Team::class, $team_number)->create();

        return array($user, $teams);
    }
}
