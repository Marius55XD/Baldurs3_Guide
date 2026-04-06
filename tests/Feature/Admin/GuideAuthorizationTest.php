<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_cannot_access_guide_creation(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $response = $this->actingAs($editor)->get(route('admin.guides.create'));

        $response->assertForbidden();
    }

    public function test_editor_cannot_store_update_or_delete_guides(): void
    {
        $editor = User::factory()->create([
            'role' => 'editor',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::create([
            'name' => 'Combat',
            'description' => 'Combat guides',
            'icon' => 'bi-shield',
        ]);

        $guide = Guide::create([
            'title' => 'Guide',
            'slug' => 'guide',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'status' => 'draft',
            'featured_image' => null,
        ]);

        $storeResponse = $this->actingAs($editor)->post(route('admin.guides.store'), [
            'title' => 'Editor Guide',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $updateResponse = $this->actingAs($editor)->put(route('admin.guides.update', $guide), [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt',
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $deleteResponse = $this->actingAs($editor)->delete(route('admin.guides.destroy', $guide));

        $storeResponse->assertForbidden();
        $updateResponse->assertForbidden();
        $deleteResponse->assertForbidden();
    }
}
