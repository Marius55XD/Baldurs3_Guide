<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Guide;
use App\Models\GuidePurchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class GuideStripeCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_stripe_session_is_created_for_a_guest_protected_guide(): void
    {
        config([
            'services.stripe.secret' => 'sk_test_123',
            'services.stripe.base_url' => 'https://api.stripe.com',
        ]);

        $author = User::factory()->create([
            'role' => 'user',
        ]);

        $buyer = User::factory()->create([
            'role' => 'user',
        ]);

        $category = Category::create([
            'name' => 'Strategies',
            'slug' => 'strategies',
            'description' => 'Battle tips',
            'icon' => '🗺️',
        ]);

        $guide = Guide::create([
            'title' => 'Stripe Test Guide',
            'slug' => 'stripe-test-guide',
            'content' => 'Paid content',
            'excerpt' => 'Paid content',
            'category_id' => $category->id,
            'user_id' => $author->id,
            'status' => 'published',
            'views' => 0,
        ]);

        Http::fake(function ($request) use ($guide, $buyer) {
            if ($request->method() === 'POST' && Str::endsWith($request->url(), '/v1/checkout/sessions')) {
                return Http::response([
                    'id' => 'cs_test_123',
                    'url' => 'https://checkout.stripe.test/session/cs_test_123',
                ]);
            }

            return Http::response([], 500);
        });

        $response = $this->actingAs($buyer)
            ->postJson(route('guides.checkout.stripe.session', $guide->slug));

        $response->assertOk();
        $response->assertJson([
            'id' => 'cs_test_123',
            'url' => 'https://checkout.stripe.test/session/cs_test_123',
        ]);

        $this->assertDatabaseCount('guide_purchases', 0);
    }

    public function test_stripe_success_verification_creates_purchase(): void
    {
        config([
            'services.stripe.secret' => 'sk_test_123',
            'services.stripe.base_url' => 'https://api.stripe.com',
        ]);

        $author = User::factory()->create([
            'role' => 'user',
        ]);

        $buyer = User::factory()->create([
            'role' => 'user',
        ]);

        $category = Category::create([
            'name' => 'Builds',
            'slug' => 'builds',
            'description' => 'Build guides',
            'icon' => '🧙',
        ]);

        $guide = Guide::create([
            'title' => 'Stripe Success Guide',
            'slug' => 'stripe-success-guide',
            'content' => 'Paid content',
            'excerpt' => 'Paid content',
            'category_id' => $category->id,
            'user_id' => $author->id,
            'status' => 'published',
            'views' => 0,
        ]);

        Http::fake(function ($request) use ($guide, $buyer) {
            if ($request->method() === 'GET' && Str::contains($request->url(), '/v1/checkout/sessions/cs_test_456')) {
                return Http::response([
                    'id' => 'cs_test_456',
                    'status' => 'complete',
                    'payment_status' => 'paid',
                    'client_reference_id' => (string) $buyer->id,
                    'metadata' => [
                        'guide_id' => (string) $guide->id,
                        'user_id' => (string) $buyer->id,
                    ],
                ]);
            }

            return Http::response([], 500);
        });

        $response = $this->actingAs($buyer)
            ->get(route('guides.checkout.stripe.success', [
                'slug' => $guide->slug,
                'session_id' => 'cs_test_456',
            ]));

        $response->assertRedirect(route('guides.show', $guide->slug));

        $this->assertDatabaseHas('guide_purchases', [
            'user_id' => $buyer->id,
            'guide_id' => $guide->id,
            'amount' => '4.99',
        ]);

        $this->assertSame(1, GuidePurchase::count());
    }
}