<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use App\Models\User;
use App\Models\Vote;
use Arr;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->setUpFaker();

        $users = User::factory(10)->create()->tap(function ($users): void {
            $users->each->assignRole('hosteller');
        });
        $amenities = Amenity::factory(10)->create();
        $categories = Category::factory(10)->create();

        foreach ($users as $user) {
            /** @var User $user */
            $hostels = Hostel::factory(10)->hasComments(2)->create([
                'owner_id' => $user->id,
            ]);

            foreach ($hostels as $hostel) {
                /** @var Hostel $hostel */
                $votes = Vote::factory(random_int(1, 5))->create([
                    'hostel_id' => $hostel->id,
                ]);
                $hostel->amenities()->attach($amenities->random(random_int(1, 3))->pluck('id')->toArray());
                $hostel->categories()->attach($categories->random(random_int(1, 3))->pluck('id')->toArray());

                $hostel->subscribers()->attach(User::factory()->create());

                $hostel->visitLog(Arr::random([null, $users->random()]))->log();

                $hostel->addMedia($this->getRandomHostelImagePath())
                    ->preservingOriginal()
                    ->setFileName('fake.webp')
                    ->toMediaCollection()
                ;

                $hostel->addMedia($this->getRandomHostelImagePath())
                    ->preservingOriginal()
                    ->setFileName('fake.webp')
                    ->toMediaCollection()
                ;

                $hostel->addMedia($this->getRandomHostelImagePath())
                    ->preservingOriginal()
                    ->setFileName('fake.webp')
                    ->toMediaCollection()
                ;

                $hostel->addMedia($this->getRandomHostelImagePath())
                    ->preservingOriginal()
                    ->setFileName('fake.webp')
                    ->toMediaCollection()
                ;

                $hostel->addMedia($this->getRandomHostelImagePath())
                    ->preservingOriginal()
                    ->setFileName('fake.webp')
                    ->toMediaCollection()
                ;
            }
        }
    }

    protected function getRandomHostelImagePath()
    {
        return __DIR__.'/hostel-images/hostel-'.random_int(1, 18).'.webp';
    }
}
