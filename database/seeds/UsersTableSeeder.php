<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Смит',
            'surname' => 'Офелия',
            'birthday' => '1983-06-14',
            'gender' => 'женский',
            'email' => 'ofelia@mail.ru'
        ]);

        DB::table('users')->insert([
            'name' => 'Джон',
            'surname' => 'Рэмси',
            'birthday' => '1992-03-01',
            'gender' => 'мужской',
            'email' => 'ramsey@gmail.com'
        ]);

        DB::table('users')->insert([
            'name' => 'Этан',
            'surname' => 'Ричардсон',
            'birthday' => '1974-11-05',
            'gender' => 'мужской',
            'email' => 'richy@mail.ru'
        ]);

        DB::table('users')->insert([
            'name' => 'Гордон',
            'surname' => 'Франклин',
            'birthday' => '1980-02-02',
            'gender' => 'мужской',
            'email' => 'gfranklin@tut.by'
        ]);

        DB::table('users')->insert([
            'name' => 'Кэролайн',
            'surname' => 'Эткинс',
            'birthday' => '1994-08-12',
            'gender' => 'женский',
            'email' => ''
        ]);

        DB::table('users')->insert([
            'name' => 'Келли',
            'surname' => 'Харпер',
            'birthday' => '1972-06-22',
            'gender' => 'женский',
            'email' => 'harperkelly@gmail.com'
        ]);

        DB::table('users')->insert([
            'name' => 'Василий',
            'surname' => 'Пупкин',
            'birthday' => '1988-08-12',
            'gender' => 'мужской',
            'email' => 'vpupkin@gmail.com',
            'password' => bcrypt('qwerty'),
            'phone' => '+375292222222',
            'is_admin' => true
        ]);
    }
}
