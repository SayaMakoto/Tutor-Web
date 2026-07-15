<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteRejectedTutors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-rejected-tutors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who registered as tutors but were rejected more than 5 minutes ago.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tutors = \App\Models\Tutor::where('status', 'rejected')
            ->where('updated_at', '<=', now()->subMinutes(5))
            ->get();

        foreach ($tutors as $tutor) {
            if ($tutor->user) {
                $tutor->user->delete();
            }
            $tutor->delete();
        }

        $oldTutors = \App\Models\Tutor::onlyTrashed()
            ->where('deleted_at', '<=', now()->subDays(30))
            ->get();

        foreach ($oldTutors as $oldTutor) {
            $user = \App\Models\User::onlyTrashed()->where('id', $oldTutor->user_id)->first();
            if ($user) {
                $user->forceDelete();
            }
            $oldTutor->forceDelete();
        }

        return Command::SUCCESS;
    }
}