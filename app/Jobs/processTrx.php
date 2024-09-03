<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Storage;

class processTrx implements ShouldQueue
{
    use Queueable;

    public $file;

    /**
     * Create a new job instance.
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Read the file contents
        $fileContents = Storage::disk('public')->get($this->file);

        // Split contents into individual transactions
        $transactions = explode("\t\t\t\t\t\t\n", $fileContents); // Assuming double newline separates transactions

        // Remove the first two transactions (they are not needed)
        array_shift($transactions);
        array_shift($transactions);

        foreach ($transactions as $transaction) {
            // Process the transaction
            $this->process($transaction);
        }
    }

    public function process($transaction): void
    {
        // Description: Process the transaction

        // Remove unnecessary characters (such as special characters)
        $transaction = str_replace("\u{A0}", "", $transaction);

        // Split lines
        $lines = explode("\n", trim($transaction));

        // Initialize transaction data array
        $data = [];

        foreach ($lines as $line) {
            // Date
            if (strpos($line, 'Date:') !== false) {
                $rawDate = trim(str_replace('Date:', '', $line));
                $data['date'] = $this->cleanDateString($rawDate);
            } else if (strpos($line, 'Description:') !== false) {
                $data['description'] = trim(str_replace('Description:', '', $line));
            } else if (strpos($line, 'Amount:') !== false) {
                $data['amount'] = trim(str_replace('Amount:', '', $line));

                // Determine if its an income or expense
                if (strpos($data['amount'], '-') !== false) {
                    $data['type'] = 'expense';
                } else {
                    $data['type'] = 'income';
                }

                // Remove the sign
                $data['amount'] = str_replace('-', '', $data['amount']);

                // Remove . from the amount
                $data['amount'] = str_replace('.', '', $data['amount']);
            }
        }

        // Now, create a new File model entry
        Transaction::create([
            'trx_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $data['date']),
            'description' => $data['description'],
            'amount' => $data['amount'],
            'user_id' => auth()->id(),
            'type' => $data['type'],
        ]);

    }

    protected function cleanDateString($dateString)
    {
        // Remove non-printable characters
        $cleaned = preg_replace('/[[:^print:]]/', '', $dateString);

        // Trim any remaining spaces
        return trim($cleaned);
    }
}
