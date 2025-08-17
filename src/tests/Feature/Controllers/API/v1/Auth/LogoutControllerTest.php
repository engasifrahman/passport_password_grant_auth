<?php

namespace Tests\Feature\Controllers\API\v1\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Feature\PassportAccessClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Store password client ID
     *
     * @var mixed
     */
    private $clientId;

    /**
     * Store password client secret
     *
     * @var mixed
     */
    private $clientSecret;

    /**
     * Set up the test environment.
     * This method runs before each test case.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a personal access client for testing
        [$this->clientId, $this->clientSecret] = PassportAccessClient::createPasswordAccessClient();
    }

    /**
     * Test that an authenticated user can successfully log out.
     *
     * @return void
     */
    public function testAuthenticatedUserCanLogoutSuccessfully(): void
    {
        // Arrange
        $password = 'password123';
        $user = User::factory()->create([
            'password' => $password,
        ]);

        $tokenResponse = $this->postJson(url('/api/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $user->email,
            'password' => $password,
            'scope' => '',
        ]);

        $token = $tokenResponse->json('access_token');

        // Ensure the user has an access token before the logout attempt.
        $this->assertNotNull($token);

        // Act
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('v1.auth.logout'));

        // Assert
        $response->assertOk()
                 ->assertJson([
                     'status'  => 'success',
                     'message' => 'Logged out successfully.'
                 ]);

        // Assert
        $user->refresh();
        $this->assertNull($user->currentAccessToken());
    }

    /**
     * Test that an unauthenticated user cannot log out and receives a 401 Unauthorized response.
     *
     * @return void
     */
    public function testUnauthenticatedUserCannotLogout(): void
    {
        // Arrange
        // No authentication is needed, as we are testing the unauthorized case.
        // The user is not logged in by default.

        // Act
        $response = $this->postJson(route('v1.auth.logout'));

        // Assert
        $response->assertUnauthorized()
                 ->assertJson([
                     'message' => 'Unauthenticated.'
                 ]);
    }
}
