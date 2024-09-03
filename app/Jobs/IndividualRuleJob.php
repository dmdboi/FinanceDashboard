<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Log;

use App\Models\Rule;


class IndividualRuleJob implements ShouldQueue
{
    use Queueable;

    public $rule;

    public $from_date;

    /**
     * Create a new job instance.
     */
    public function __construct(Rule $rule, ?string $from_date = null)
    {
        // Required parameter
        $this->rule = $rule;

        // Optional parameter
        $this->from_date = $from_date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Description: Runs a single rule against all transactions

        // Get all transactions
        $transactions = $this->from_date
            ? Transaction::where('date', '>=', $this->from_date)->get()
            : Transaction::all();

        Log::info('Processing ' . $transactions->count() . ' transactions for rule ' . $this->rule->id);

        // Run the rule against each transaction
        foreach ($transactions as $transaction) {
            // Check if the rule matches the transaction
            if ($this->rule->matchesRule($transaction)) {
                // Categorize the transaction
                $transaction->categorize($this->rule->category_id);
            }
        }
    }
}
