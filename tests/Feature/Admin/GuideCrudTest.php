<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_guide(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Combat',
            'description' => 'Combat guides',
            'icon' => 'bi-shield',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.guides.store'), [
            'title' => 'How to Beat Ketheric',
            'content' => 'Use radiant damage and high ground.',
            'excerpt' => 'A quick boss fight guide.',
            'category_id' => $category->id,
            'status' => 'published',
            'featured_image' => 'https://example.com/guide.jpg',
        ]);

        $response->assertRedirect(route('admin.guides.index'));

        $this->assertDatabaseHas('guides', [
            'title' => 'How to Beat Ketheric',
            'slug' => 'how-to-beat-ketheric',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'status' => 'published',
        ]);
    }

    public function test_admin_can_update_a_guide(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Combat',
            'description' => 'Combat guides',
            'icon' => 'bi-shield',
        ]);

        $guide = Guide::create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'content' => 'Old content',
            'excerpt' => 'Old excerpt',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'status' => 'draft',
            'featured_image' => null,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.guides.update', $guide), [
            'title' => 'New Title',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt',
            'category_id' => $category->id,
            'status' => 'published',
            'featured_image' => 'https://example.com/new-guide.jpg',
        ]);

        $response->assertRedirect(route('admin.guides.index'));

        $this->assertDatabaseHas('guides', [
            'id' => $guide->id,
            'title' => 'New Title',
            'slug' => 'new-title',
            'content' => 'Updated content',
            'status' => 'published',
            'featured_image' => 'https://example.com/new-guide.jpg',
        ]);
    }

    public function test_admin_can_delete_a_guide(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Combat',
            'description' => 'Combat guides',
            'icon' => 'bi-shield',
        ]);

        $guide = Guide::create([
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'status' => 'draft',
            'featured_image' => null,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.guides.destroy', $guide));

        $response->assertRedirect(route('admin.guides.index'));

        $this->assertDatabaseMissing('guides', [
            'id' => $guide->id,
        ]);
    }
}
