<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ResetAllPasswords extends Command
{
    use SendsPasswordResetEmails;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:reset-all-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets all the users\' passwords in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        $this->info(sprintf('This will reset the password of %d users.', count($users)));

        $bar = $this->output->createProgressBar(count($users));

        if (! $this->confirm('Do you wish to continue?')) {
            return;
        }

        foreach ($users as $user) {
            // Send password reset link to the user
            $response = $this->broker()->sendResetLink(
                ['email' => $user->email], $this->resetNotifier()
            );

            $bar->advance();
        }

        $bar->finish();
    }
}
