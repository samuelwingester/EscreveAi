<?php

namespace Tests\Feature\tests\Feature\Http\Controllers;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use Laravel\Sanctum\Sanctum;

use App\Models\Enums\Gender;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'teste@teste.teste';
    private string $password = 'testeteste';

    private function createUser() : User
    {
        return User::factory()->teacher()->create([
            'email'     => $this->email,
            'password'  => Hash::make( $this->password )
        ]);
    }

    public function test_login_success(): void
    {
        $user = $this->createUser();

        $request = $this->withHeader('User-Agent', 'TESTE');

        $response = $request->postJson('/api/login', [
            'email'     => $this->email,
            'password'  => $this->password,
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'user' => [ 'id', 'name', 'email', 'gender', 'created_at','updated_at' ], 'token'
        ]);

        $response->assertJsonPath('user.email', $this->email);
    }

    public function test_login_invalid_credentials(): void
    {
        $this->createUser();

        $response = $this->postJson('/api/login', [
            'email'     => $this->email,
            'password'  => 'irineuireneu',
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_validation_error(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([ 'email', 'password' ]);
    }

    public function test_register_success(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => '  teste   teste  ',
            'email' => '  TESTE@EMAIL.COM ',
            'password' => 'testeteste',
            'password_confirmation' => 'testeteste',
            'gender' => Gender::MAN->value,
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'user' => [ 'id', 'name', 'email', 'gender', 'created_at','updated_at' ], 'token'
        ]);

        $response->assertJsonPath('user.name', 'Teste Teste');

        $response->assertJsonPath('user.email', 'teste@email.com');

        $this->assertDatabaseHas('users', [
            'email' => 'teste@email.com',
            'name' => 'teste teste',
        ]);
    }

    public function test_register_duplicate_email(): void
    {
        $this->createUser();

        $response = $this->postJson('/api/register', [
            'name'      => 'TESTE',
            'email'     => $this->email,
            'password'  => $this->password,
            'password_confirmation' => $this->password
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors('email');
    }

    public function test_logout_success(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertNoContent();

        $this->assertCount(0, $user->fresh()->tokens);
    }

    public function test_get_authenticated_user(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/user');

        $response->assertOk();

        $response->assertJsonPath('user.id', $user->id);

        $response->assertJsonPath('user.email', $user->email);
    }

    public function test_user_requires_authentication(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertUnauthorized();
    }
}
