<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserNotifications;
use App\Models\UserPublicationLike;
use App\Models\UserSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Publication::truncate();
        UserSubscription::truncate();
        UserPublicationLike::truncate();
        UserNotification::truncate();
        PublicationComment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Створення користувачів...');
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nickname' => 'superadmin',
            'password' => bcrypt('admin'),
        ]);
        $users = User::factory(50)->create();
        $this->command->info('Користувачів створено.');

        $this->command->info('Створення публікацій...');
        $this->command->getOutput()->progressStart($users->count());
        foreach ($users as $user) {
            Publication::factory(rand(0, 15))->create(['user_id' => $user->id]);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        $publications = Publication::all();

        $this->command->info('Створення підписок...');
        $this->command->getOutput()->progressStart($users->count());
        foreach ($users as $user) {
            if ($users->count() > 1) {
                $usersToFollow = $users->where('id', '!=', $user->id)->random(min(rand(0, 20), $users->count() - 1));
                foreach ($usersToFollow as $userToFollow) {
                    UserSubscription::factory()->create([
                        'user_id' => $user->id,
                        'subscribed_to_id' => $userToFollow->id,
                        'is_accepted' => $userToFollow->is_private ? fake()->boolean(70) : true,
                    ]);
                }
            }
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        if ($publications->isNotEmpty()) {
            $this->command->info('Створення лайків...');
            $this->command->getOutput()->progressStart($users->count());
            foreach ($users as $user) {
                $publicationsToLike = $publications->random(min(rand(0, 50), $publications->count()));
                foreach ($publicationsToLike as $publication) {
                    if ($user->id !== $publication->user_id) {
                        UserPublicationLike::factory()->create([
                            'user_id' => $user->id,
                            'publication_id' => $publication->id,
                        ]);
                    }
                }
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
        }

        if ($publications->isNotEmpty() && $users->count() > 1) {
            $this->command->info('Створення коментарів...');
            $this->command->getOutput()->progressStart($publications->count());
            foreach ($publications as $publication) {
                $commentingUsers = $users->where('id', '!=', $publication->user_id)->random(min(rand(0, 10), $users->count() - 1));

                foreach ($commentingUsers as $commentingUser) {
                    PublicationComment::factory()->create([
                        'publication_id' => $publication->id,
                        'user_id' => $commentingUser->id,
                    ]);
                }
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
        }

        $this->command->info('Створення повідомлень від адміністратора...');
        if ($users->count() >= 5) {
            $usersForNotification = $users->random(5);
            foreach ($usersForNotification as $user) {
                UserNotification::factory()->create([
                    'user_id' => $admin->id,
                    'sent_to_id' => $user->id,
                    'topic' => 'warning',
                    'message' => 'Це тестове попередження. Будь ласка, дотримуйтесь правил спільноти.'
                ]);
            }
        }
        $this->command->info('Дані успішно згенеровано!');
    }
}

