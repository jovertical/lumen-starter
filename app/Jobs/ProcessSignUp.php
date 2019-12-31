<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Notifications\Welcome;
use App\User;

class ProcessSignUp extends Job
{
    /**
     * The user that will receive the notification.
     */
    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(new Welcome());
    }
}
