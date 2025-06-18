<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBirthdayEmail;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BirthdayGreetingMail;
use Carbon\Carbon;

class SendBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email ucapan ulang tahun ke pelanggan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('m-d');

        $users = User::whereHas('customer', function ($query) use ($today) {
            $query->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [$today]);
        })->get();

        foreach ($users as $user) {
            ProcessBirthdayEmail::dispatch($user)->onQueue('birthday-email');
        }
        $this->info("Email dikirim ke: {$user->email}");
    }
}
