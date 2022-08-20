<?php

namespace Tests\Feature\Models;

use App\Models\Team;
use App\Models\User;
use CodencoDev\EloquentModelTester\HasModelTester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use HasModelTester;
    use RefreshDatabase;

    public function test_user_model_has_expected_schema()
    {
        $this->modelTestable(User::class)
            ->assertHasColumns([
                'id',
                'uid',
                'name',
                'email',
                'email_verified_at',
                'password',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
                'remember_token',
                'current_team_id',
                'profile_photo_path',
                'created_at',
                'updated_at'
            ]);
    }

    public function test_user_model_has_expected_fillable_fields()
    {
        $this->modelTestable(User::class)
            ->assertCanFillables(['name', 'email', 'email_verified_at', 'password',]);
    }

    public function test_a_user_belongs_to_a_current_team()
    {
        $this->modelTestable(User::class)
            ->assertHasBelongsToRelation(Team::class, 'currentTeam', 'current_team_id');
    }

    public function test_a_user_has_many_teams()
    {
        $this->modelTestable(User::class)
            ->assertHasHasManyRelation(Team::class, 'teams');
    }

    public function test_a_user_can_own_many_teams()
    {
        $this->modelTestable(User::class)
            ->assertHasHasManyRelation(Team::class, 'ownedTeams');
    }
}
