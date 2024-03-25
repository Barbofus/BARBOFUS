<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendDiscordWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $url;

    /**
     * @var array<string, mixed>
     */
    protected $body;

    /**
     * Create a new job instance.
     *
     * @param  array<string, mixed>  $body
     * @return void
     */
    public function __construct(string $url, array $body)
    {
        $this->url = $url;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Http::post($this->url, $this->body);
    }
}
