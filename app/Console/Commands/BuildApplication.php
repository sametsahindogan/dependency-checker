<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class BuildApplication
 * @package App\Console\Commands
 */
class BuildApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare application.';

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
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $this->info(shell_exec('composer run-script c'));

        $this->info('Migration and seed process complete.');

        $email = 'test@example.com';

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if($user instanceof User) $user->forceDelete();

        $password = 'password';

        User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info(shell_exec('composer run-script c'));

        $this->warn('Test user created!');

        $this->alert(PHP_EOL.$email.PHP_EOL.$password.PHP_EOL);

        $this->info('Application is ready now!');

        return;
    }
}
