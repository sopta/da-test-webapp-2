<?php

namespace Database\Seeders;

use Carbon\Carbon;
use CzechitasApp\Models\Category;
use CzechitasApp\Models\Enums\OrderType;
use CzechitasApp\Models\Enums\StudentLogOutType;
use CzechitasApp\Models\Enums\StudentPaymentType;
use CzechitasApp\Models\Order;
use CzechitasApp\Models\Student;
use CzechitasApp\Models\StudentPayment;
use CzechitasApp\Models\Term;
use CzechitasApp\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        $master = User::where(['role' => 'master'])->orderBy('created_at')->first();
        $admin = User::where(['role' => 'admin'])->orderBy('created_at')->first();

        if ($master == null || $admin == null) {
           throw new \Exception("Cannot find user with 'master' and 'admin' role");
        }

        $parent1 = User::create([
            'name'      => "Rodič Radka",
            'email'     => "da-app.parent-radka@czechitas.cz",
            'password'  => Hash::make("Czechitas123"),
            'role'      => "parent",
        ]);
        $parent2 = User::create([
            'name'      => "Rodič Maria",
            'email'     => "da-app.parent-maria@czechitas.cz",
            'password'  => Hash::make("Czechitas123"),
            'role'      => "parent",
        ]);

        // Orders
        $startDate1 = Carbon::now()->addMonths(2)->next(Carbon::MONDAY);
        Order::create([
            'type' => OrderType::CAMP,
            'client' => 'Czechitas z.s.',
            'address' => 'Václavské náměstí 837, 11000 Praha',
            'ico' => '03205797',
            'substitute' => 'Jára Cimrman',
            'contact_name' => 'Jaroslav Seifert',
            'contact_tel' => '+42012345789',
            'contact_mail' => 'jarda@seifert.com',
            'start_date_1' => $startDate1,
            'xdata' => [
                'end_date_1' => $startDate1->clone()->next(Carbon::FRIDAY),
                'students' => 20,
                'age' => '12-20 let',
                'adults' => 2,
                'date_part' => 'forenoon',
            ],
        ]);

        $startDate2 = Carbon::now()->addDays(45)->next(Carbon::MONDAY);
        Order::create([
            'type' => OrderType::SCHOOL_NATURE,
            'client' => 'Czechitas z.s.',
            'address' => 'Václavské náměstí 837, 11000 Praha',
            'ico' => '03205797',
            'substitute' => 'T.G. Masaryk',
            'contact_name' => 'Leoš Janáček',
            'contact_tel' => '+420987654321',
            'contact_mail' => 'leos@liska-bystrouska.cz',
            'start_date_1' => $startDate1,
            'start_date_2' => $startDate2,
            'xdata' => [
                'end_date_1' => $startDate1->clone()->next(Carbon::FRIDAY),
                'end_date_2' => $startDate2->clone()->next(Carbon::FRIDAY),
                'students' => 45,
                'age' => '6-15 let',
                'adults' => 7,
                'start_time' => '16:30',
                'start_food' => 'dinner',
                'end_time' => '11:00',
                'end_food' => 'lunch',
            ],
        ]);

        // Categories
        $categoryProgramming = Category::create([
            'name' => 'Programování',
            'slug' => '666-programovani',
            'position' => 1,
        ]);

        Category::create([
            'name' => 'Testování',
            'slug' => '123-testovani',
            'position' => 2,
        ]);

        $categoryJS = Category::create([
            'parent_id' => $categoryProgramming->id,
            'name' => 'JavaScript',
            'slug' => '137-javascript',
            'position' => 1,
        ]);

        $categoryPython = Category::create([
            'parent_id' => $categoryProgramming->id,
            'name' => 'Python',
            'slug' => '139-python',
            'position' => 2,
        ]);

        // Terms
        $termInPast = Term::create([
            'category_id' => $categoryJS->id,
            'start' => new Carbon('2021-01-11'),
            'end' => new Carbon('2021-01-15'),
            'opening' => new Carbon('2020-12-01T15:00:00+01:00'),
            'price' => 2500,
        ]);

        $futureStart = Carbon::now()->addMonths(4)->next(Carbon::MONDAY);
        $futureTerm = Term::create([
            'category_id' => $categoryPython->id,
            'start' => $futureStart,
            'end' => $futureStart->clone()->next(Carbon::FRIDAY),
            'price' => 1800,
        ]);

        /////////////////////////////////////////
        // Students in Past Term with payments //
        /////////////////////////////////////////
        $student = Student::create([
            'parent_id' => $admin->id,
            'term_id' => $termInPast->id,
            'parent_name' => 'Tim Berners-Lee',
            'forename' => 'Bruce',
            'surname' => 'Lee',
            'birthday' => new Carbon(),
            'email' => $admin->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 456,
        ]);
        StudentPayment::create([
            'student_id' => $student->id,
            'price' => $termInPast->price,
            'payment' => StudentPaymentType::TRANSFER,
            'user_id' => $master->id,
            'received_at' => $termInPast->start->subDays(18),
            'created_at' => $termInPast->start->subDays(18),
            'updated_at' => $termInPast->start->subDays(18),
        ]);

        $student = Student::create([
            'parent_id' => $parent1->id,
            'term_id' => $termInPast->id,
            'parent_name' => 'Bill Gates',
            'forename' => 'Junior Bill',
            'surname' => 'Gates',
            'birthday' => new Carbon(),
            'email' => $parent1->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 789,
        ]);
        StudentPayment::create([
            'student_id' => $student->id,
            'price' => 500,
            'payment' => StudentPaymentType::CASH,
            'user_id' => $master->id,
            'received_at' => $termInPast->start->subDays(30),
            'created_at' => $termInPast->start->subDays(30),
            'updated_at' => $termInPast->start->subDays(30),
        ]);
        StudentPayment::create([
            'student_id' => $student->id,
            'price' => $termInPast->price - 200,
            'payment' => StudentPaymentType::TRANSFER,
            'user_id' => $master->id,
            'received_at' => $termInPast->start->subDays(15),
        ]);

        $student = Student::create([
            'parent_id' => $parent1->id,
            'term_id' => $termInPast->id,
            'parent_name' => 'Linus Torvalds',
            'forename' => 'Alan',
            'surname' => 'Turing',
            'birthday' => new Carbon(),
            'email' => $parent1->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 159,
            'logged_out' => StudentLogOutType::ILLNESS,
            'logged_out_date' => $termInPast->start->addDays(2),
            'restrictions' => 'Alergie na laktozu',
        ]);

        $student = Student::create([
            'parent_id' => $parent2->id,
            'term_id' => $termInPast->id,
            'parent_name' => 'Steve Jobs',
            'forename' => 'Steve',
            'surname' => 'Wozniak',
            'birthday' => new Carbon(),
            'email' => $parent2->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 753,
            'canceled' => 'Omylem vytvořená přihláška',
        ]);

        ///////////////////////////////////////////
        // Students in Future Term with payments //
        ///////////////////////////////////////////
        $student = Student::create([
            'parent_id' => $parent2->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Grace Hopper',
            'forename' => 'Hedy',
            'surname' => 'Lamarr',
            'birthday' => new Carbon(),
            'email' => $parent2->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 1793,
        ]);
        StudentPayment::create([
            'student_id' => $student->id,
            'price' => $futureTerm->price + 1000,
            'payment' => StudentPaymentType::TRANSFER,
            'note' => 'Příspěvek za vynález zabraňující odposlechu u Wi-Fi',
            'user_id' => $master->id,
            'received_at' => Carbon::now(),
        ]);

        Student::create([
            'parent_id' => $parent1->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Annie Easley',
            'forename' => 'Mary',
            'surname' => 'Wilkes',
            'birthday' => new Carbon(),
            'email' => $parent1->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 1946,
        ]);

        Student::create([
            'parent_id' => $parent1->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Karen Sparck-Jones',
            'forename' => 'Ada',
            'surname' => 'Lovelace',
            'birthday' => new Carbon(),
            'email' => $parent1->email,
            'payment' => StudentPaymentType::FKSP,
            'variable_symbol' => 3486,
        ]);

        Student::create([
            'parent_id' => $parent1->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Adele Goldberg',
            'forename' => 'Radia',
            'surname' => 'Perlman',
            'birthday' => new Carbon(),
            'email' => $parent1->email,
            'payment' => StudentPaymentType::FKSP,
            'variable_symbol' => 1278,
            'logged_out' => StudentLogOutType::ILLNESS,
            'logged_out_date' => $futureTerm->start->addDays(2),
        ]);

        Student::create([
            'parent_id' => $parent2->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Katherine Johnson',
            'forename' => 'Elizabeth',
            'surname' => 'Feinler',
            'birthday' => new Carbon(),
            'email' => $parent2->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 2846,
        ]);

        Student::create([
            'parent_id' => $parent2->id,
            'term_id' => $futureTerm->id,
            'parent_name' => 'Katherine Johnson',
            'forename' => 'Elizabeth',
            'surname' => 'Feinler',
            'birthday' => new Carbon(),
            'email' => $parent2->email,
            'payment' => StudentPaymentType::TRANSFER,
            'variable_symbol' => 2844,
            'canceled' => 'Dvakrát vytvořená stejná přihláška',
        ]);
    }
}
