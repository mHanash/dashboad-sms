<?php

namespace App\Jobs;

use App\Models\Phone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePhone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public array $datas = [];
    /**
     * Create a new job instance.
     */
    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->datas as $key => $value) {
            $item = Phone::where('number', '=', $value['to']);
            $item->update(['is_submit' => true]);
        }
    }
}
