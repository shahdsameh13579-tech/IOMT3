<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Log;
use App\Models\Analysis;
use App\Models\Finding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ForensicsAppTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Jane Analyst',
            'email' => 'jane@forensics.ai',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'analyst'
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'jane@forensics.ai',
            'role' => 'analyst'
        ]);
        $this->assertAuthenticated();
    }

    public function test_analyst_cannot_access_admin_users()
    {
        $analyst = User::factory()->create([
            'role' => 'analyst'
        ]);

        $response = $this->actingAs($analyst)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_users()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_log_upload_and_analysis_pipeline()
    {
        Storage::fake('local');
        
        $analyst = User::factory()->create([
            'role' => 'analyst'
        ]);

        // Mock Python FastAPI response
        Http::fake([
            'http://127.0.0.1:8000/analyze-log' => Http::response([
                'total_entries' => 3,
                'total_findings' => 1,
                'attack_types' => [
                    'SQLi' => 1,
                    'XSS' => 0,
                    'Directory Traversal' => 0,
                    'Command Injection' => 0,
                    'Zero-Day Anomaly' => 0
                ],
                'top_ips' => ['192.168.1.15'],
                'zero_day_rate' => 0.0,
                'accuracy' => 0.95,
                'findings' => [
                    [
                        'ip' => '192.168.1.15',
                        'attack_type' => 'SQLi',
                        'severity' => 'High',
                        'request_uri' => '/products?id=12%20UNION%20SELECT%20NULL',
                        'status' => 200,
                        'timestamp' => '23/May/2026:19:20:01 +0300'
                    ]
                ]
            ], 200)
        ]);

        $fakeLogContent = '192.168.1.10 - - [23/May/2026:19:19:40 +0300] "GET / HTTP/1.1" 200 3426 "http://localhost/" "Mozilla/5.0"\n' .
                         '192.168.1.15 - - [23/May/2026:19:20:01 +0300] "GET /products?id=12%20UNION%20SELECT%20NULL,username,password%20FROM%20users-- HTTP/1.1" 200 8203 "http://localhost/products" "Mozilla/5.0"\n' .
                         '192.168.1.20 - - [23/May/2026:19:21:10 +0300] "GET /contact HTTP/1.1" 200 2400 "http://localhost/" "Mozilla/5.0"';

        $file = UploadedFile::fake()->createWithContent('access.log', $fakeLogContent);

        $response = $this->actingAs($analyst)->post('/upload', [
            'log_file' => $file
        ]);

        $this->assertDatabaseHas('logs', [
            'file_name' => 'access.log',
            'uploaded_by' => $analyst->id
        ]);

        $logRecord = Log::where('file_name', 'access.log')->first();
        
        $this->assertDatabaseHas('analyses', [
            'log_id' => $logRecord->id,
            'total_entries' => 3,
            'total_findings' => 1,
            'zero_day_rate' => 0.0
        ]);

        $analysis = Analysis::where('log_id', $logRecord->id)->first();

        $this->assertDatabaseHas('findings', [
            'analysis_id' => $analysis->id,
            'ip' => '192.168.1.15',
            'attack_type' => 'SQLi',
            'severity' => 'High',
            'status' => 200
        ]);

        $response->assertRedirect(route('analysis.show', $analysis));
    }
}
