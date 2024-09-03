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
        // Take the transaction data and run it through the categorization process

        $rules = Rule::all();

        foreach ($rules as $rule) {
            // Check if the rule matches the transaction
            if ($this->matchesRule($rule)) {
                $this->categorize($rule);
            }
        }
    }

    public function matchesRule(Rule $rule): bool
    {
        if ($rule->operator == 'contains') {
            return strpos($this->trx[$rule->property], $rule->value) !== false;
        }

        if ($rule->operator == 'equals') {
            return $this->trx[$rule->property] == $rule->value;
        }

        return false;
    }

    public function categorize($rule): void
    {
        // Categorize the transaction
        $this->trx['category_id'] = $rule->category_id;
        $this->trx->save();
    }
}
