<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use DateTime;


class DoctorTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //Создание доктора
        $response = $this->postJson('/api/create_doctor',
            [
                'name' => 'Vladimir',
                'surname' => 'Barabanov',
                'paternal_patronymic' => 'Ivanovich',
                'birthday' => '1969-12-06',
                'phone' => '4537643543',
                'begin'=> '08:45',
                'end' => '17:57',
                'email' => 'barabanovbk@mail.ru'
            ]);
        $response->assertStatus(201);
        //Запуск консольной команды формирования графика приема
        $this->artisan('command:patients');
        //Создание пациентов
        $response = $this->postJson('/api/create_patient',
            [
                'name' => 'Ivan',
                'surname' => 'Sidorov',
                'patronymic_surname' => 'Petrovich',
                'birthday' => '1954-11-09',
                'snils' => '45376423543',
                'place_of_residence'=> 'Murmansk'
            ]);
        $response->assertStatus(201);
        $response = $this->postJson('/api/create_patient',
            [
                'name' => 'Sergey',
                'surname' => 'Chepikov',
                'patronymic_surname' => 'Ivanovich',
                'birthday' => '1956-03-07',
                'snils' => '45376354380',
                'place_of_residence'=> 'Rostov-na-Dony'
            ]);
        $response->assertStatus(201);
        //Запись пациентов на прием
        $k=1;
        $l=2;
        for($i=0;$i<15;$i++)
        {
            $response = $this->postJson('/api/record_patient',
            [
               'patient_id' => 1,
               'slot' => $k
            ]);
            $response->assertStatus(200);
            $response = $this->postJson('/api/record_patient',
                [
                    'patient_id' => 2,
                    'slot' => $l
                ]);
            $response->assertStatus(200);
            $k=$k+3;
            $l=$l+3;
        }
        //Проверка результатов записи=
        $day = new DateTime('next monday');
        $begin = date_format($day,'Y-m-d');
        $day = new DateTime('next monday + 6 days');
        $end = date_format($day,'Y-m-d');;
        $uri = 'api/get_slots?offset=0&d_begin='.
            $begin.'&d_end='.$end.
            '&pname=Sidorov&dname=Vladimir&dsurname=Barabanov';
        $response = $this->getJson($uri);
        $response->assertStatus(200)
                    ->assertJson([['pname' => 'Ivan',
                            'psurname' => 'Sidorov',
                            'dname' => 'Vladimir',
                            'dsurname' => 'Barabanov']]);
        $uri = 'api/get_slots?offset=0&d_begin='.
            $begin.'&d_end='.$end.
            '&pname=Sergey&dname=Vladimir&dsurname=Barabanov';
        $response = $this->getJson($uri);
        $response->assertStatus(200)
                    ->assertJson([['pname' => 'Sergey',
                                   'psurname' => 'Chepikov',
                                    'dname' => 'Vladimir',
                                    'dsurname' => 'Barabanov']]);
    }
}
