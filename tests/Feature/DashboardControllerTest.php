<?php

namespace Tests\Feature;

use App\Models\Code;
use App\Models\CodeCategory;
use App\Models\RowCategory;
use App\Models\Snippet;
use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the ajaxList method with no filters.
     */
    public function test_ajax_list_returns_all_snippets_when_no_filters(): void
    {
        // Create test data
        $category = RowCategory::factory()->create();
        $snippets = Snippet::factory()->count(3)->create([
            'category_id' => $category->id
        ]);

        // Call the endpoint
        $response = $this->getJson('/ajax/list/filter');

        // Assert response status and structure
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'category_id',
                'category_name',
                'snippets' => [
                    '*' => [
                        'id',
                        'description',
                        'crispdm',
                        'row'
                    ]
                ]
            ]
        ]);

        // Assert that all snippets are returned
        $this->assertCount(1, $response->json());
        $this->assertCount(3, $response->json()[0]['snippets']);
    }

    /**
     * Test the ajaxList method with snippet category filter.
     */
    public function test_ajax_list_filters_by_snippet_categories(): void
    {
        // Create test data
        $category1 = RowCategory::factory()->create();
        $category2 = RowCategory::factory()->create();

        $snippet1 = Snippet::factory()->create(['category_id' => $category1->id]);
        $snippet2 = Snippet::factory()->create(['category_id' => $category2->id]);

        // Call the endpoint with filter
        $response = $this->getJson('/ajax/list/filter?snippetCategories[]=' . $category1->id);

        // Assert response status and structure
        $response->assertStatus(200);

        // Assert that only snippets from category1 are returned
        $this->assertCount(1, $response->json());
        $this->assertEquals($category1->id, $response->json()[0]['category_id']);
        $this->assertCount(1, $response->json()[0]['snippets']);
    }

    /**
     * Test the ajaxList method with crispdm filter.
     */
    public function test_ajax_list_filters_by_crispdm(): void
    {
        // Create test data
        $category = RowCategory::factory()->create();
        $snippet1 = Snippet::factory()->create([
            'category_id' => $category->id,
            'crispdm' => 1
        ]);
        $snippet2 = Snippet::factory()->create([
            'category_id' => $category->id,
            'crispdm' => 2
        ]);

        // Call the endpoint with filter
        $response = $this->getJson('/ajax/list/filter?crispdm[]=1');

        // Assert response status
        $response->assertStatus(200);

        // Assert that only snippets with crispdm=1 are returned
        $this->assertCount(1, $response->json());
        $this->assertCount(1, $response->json()[0]['snippets']);
        $this->assertEquals($snippet1->id, $response->json()[0]['snippets'][0]['id']);
    }

    /**
     * Test the ajaxList method with code categories filter.
     */
    public function test_ajax_list_filters_by_code_categories(): void
    {
        // Create test data
        $category = RowCategory::factory()->create();
        $codeCategory1 = CodeCategory::factory()->create();
        $codeCategory2 = CodeCategory::factory()->create();

        $snippet1 = Snippet::factory()->create(['category_id' => $category->id]);
        $snippet2 = Snippet::factory()->create(['category_id' => $category->id]);

        $code1 = Code::factory()->create(['code_category_id' => $codeCategory1->id]);
        $code2 = Code::factory()->create(['code_category_id' => $codeCategory2->id]);

        // Associate snippets with codes
        $snippet1->codes()->attach($code1->id);
        $snippet2->codes()->attach($code2->id);

        // Call the endpoint with filter
        $response = $this->getJson('/ajax/list/filter?codeCategories[]=' . $codeCategory1->id);

        // Assert response status
        $response->assertStatus(200);

        // Assert that only snippets associated with codeCategory1 are returned
        $this->assertCount(1, $response->json());
        $this->assertCount(1, $response->json()[0]['snippets']);
        $this->assertEquals($snippet1->id, $response->json()[0]['snippets'][0]['id']);
    }

    /**
     * Test the ajaxList method with search filter.
     */
    public function test_ajax_list_filters_by_search_term(): void
    {
        // Create test data
        $category = RowCategory::factory()->create();

        $snippet1 = Snippet::factory()->create([
            'category_id' => $category->id,
            'row' => 'This is a unique row'
        ]);

        $snippet2 = Snippet::factory()->create([
            'category_id' => $category->id,
            'row' => 'Another row'
        ]);

        // Create a translation that should match the search
        Translation::factory()->create([
            'key' => 'trans.snippet.description.' . $snippet2->id,
            'value' => 'This contains searchable text'
        ]);

        // Test searching by row content
        $response1 = $this->getJson('/ajax/list/filter?search=unique');

        // Assert that only snippet1 is returned when searching for 'unique'
        $response1->assertStatus(200);
        $this->assertCount(1, $response1->json());
        $this->assertCount(1, $response1->json()[0]['snippets']);
        $this->assertEquals($snippet1->id, $response1->json()[0]['snippets'][0]['id']);

        // Test searching by translation value
        $response2 = $this->getJson('/ajax/list/filter?search=searchable');

        // Assert that only snippet2 is returned when searching for 'searchable'
        $response2->assertStatus(200);
        $this->assertCount(1, $response2->json());
        $this->assertCount(1, $response2->json()[0]['snippets']);
        $this->assertEquals($snippet2->id, $response2->json()[0]['snippets'][0]['id']);
    }

    /**
     * Test the ajaxList method with multiple filters combined.
     */
    public function test_ajax_list_with_multiple_filters(): void
    {
        // Create test data
        $category1 = RowCategory::factory()->create();
        $category2 = RowCategory::factory()->create();

        $codeCategory1 = CodeCategory::factory()->create();
        $codeCategory2 = CodeCategory::factory()->create();

        // Create snippets with different properties
        $snippet1 = Snippet::factory()->create([
            'category_id' => $category1->id,
            'crispdm' => 1,
            'row' => 'Target row'
        ]);

        $snippet2 = Snippet::factory()->create([
            'category_id' => $category1->id,
            'crispdm' => 2,
            'row' => 'Target row'
        ]);

        $snippet3 = Snippet::factory()->create([
            'category_id' => $category2->id,
            'crispdm' => 1,
            'row' => 'Different row'
        ]);

        // Create codes and associate with snippets
        $code1 = Code::factory()->create(['code_category_id' => $codeCategory1->id]);
        $code2 = Code::factory()->create(['code_category_id' => $codeCategory2->id]);

        $snippet1->codes()->attach($code1->id);
        $snippet2->codes()->attach($code1->id);
        $snippet3->codes()->attach($code2->id);

        // Call the endpoint with multiple filters
        $response = $this->getJson('/ajax/list/filter?snippetCategories[]=' . $category1->id .
                                   '&crispdm[]=1&codeCategories[]=' . $codeCategory1->id .
                                   '&search=Target');

        // Assert response status
        $response->assertStatus(200);

        // Assert that only snippet1 matches all filters
        $this->assertCount(1, $response->json());
        $this->assertCount(1, $response->json()[0]['snippets']);
        $this->assertEquals($snippet1->id, $response->json()[0]['snippets'][0]['id']);
    }
}
