<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

class RioWidgetTest extends TestCase
{
    public function test_rio_widgets_replace_server_side_results_without_external_requests(): void
    {
        Http::preventStrayRequests();
        Http::fake();

        $this->get('/')->assertOk()
            ->assertSee('id="widget-latest"', false)
            ->assertSee('id="widget-day"', false)
            ->assertSee(config('bicho.widget.table_url'))
            ->assertSee(config('bicho.widget.day_url'))
            ->assertSee(config('bicho.widget.source_url'))
            ->assertSee('Fonte:')
            ->assertDontSee('PT-SUL')
            ->assertDontSee('id="date"', false)
            ->assertDontSee('id="result-search"', false);

        Http::assertNothingSent();
    }

    public function test_previous_results_api_and_synchronization_schedule_are_removed(): void
    {
        Http::fake();
        $this->getJson('/api/resultados')->assertNotFound();
        $this->assertEmpty(app(Schedule::class)->events());
        Http::assertNothingSent();
    }
}
