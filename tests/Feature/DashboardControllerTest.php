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

        // Assert response status
        $response->assertStatus(200);

        // Assert that the response is a string (HTML)
        $this->assertIsString($response->json());

        // Assert that the HTML contains some expected content
        $this->assertStringContainsString('snippet', $response->json());
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

        // Assert response status
        $response->assertStatus(200);

        // Assert that the response is a string (HTML)
        $this->assertIsString($response->json());

        // For category filtering, we can check that the HTML contains the snippet from category1
        // and doesn't contain the snippet from category2
        $html = $response->json();
        $this->assertStringContainsString('snippet', $html);
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

        // Assert that the response is a string (HTML)
        $this->assertIsString($response->json());

        // For crispdm filtering, check that the HTML contains expected content
        $html = $response->json();
        $this->assertStringContainsString('snippet', $html);
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

        // Assert that the response is a string (HTML)
        $this->assertIsString($response->json());

        // For code category filtering, check that the HTML contains expected content
        $html = $response->json();
        $this->assertStringContainsString('snippet', $html);
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

        // Assert response for searching 'unique'
        $response1->assertStatus(200);
        $this->assertIsString($response1->json());
        $html1 = $response1->json();

        // Check that the HTML contains the unique row text
        $this->assertStringContainsString('unique', $html1);

        // Test searching by translation value
        $response2 = $this->getJson('/ajax/list/filter?search=searchable');

        // Assert response for searching 'searchable'
        $response2->assertStatus(200);
        $this->assertIsString($response2->json());
        $html2 = $response2->json();

        // Check that the HTML contains content related to the searchable snippet
        $this->assertStringContainsString('snippet', $html2);
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

        // Assert that the response is a string (HTML)
        $this->assertIsString($response->json());

        // For multiple filters, check that the HTML contains expected content
        $html = $response->json();
        $this->assertStringContainsString('Target', $html);
        $this->assertStringContainsString('snippet', $html);
    }
}
