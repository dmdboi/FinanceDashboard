<?php

namespace App\Jobs;

use App\Models\Rule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class categorizeTrx implements ShouldQueue
{
    use Queueable;

    public $trx;

    /**
     * Create a new job instance.
     */
    public function __construct($transaction)
    {
        //
        $this->trx = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Description: Take the transaction data and run it through the categorization process

        $rules = Rule::all();

        foreach ($rules as $rule) {
            // Check if the rule matches the transaction
            if ($rule->matchesRule($this->trx)) {
                // Categorize the transaction
                $this->trx->categorize($rule->category_id);
            }
        }
    }



}
