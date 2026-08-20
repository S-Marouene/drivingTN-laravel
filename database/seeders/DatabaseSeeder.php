<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['title' => 'Examen de démonstration 1', 'description' => 'Série de questions de signalisation et de sécurité routière.'],
            ['title' => 'Examen de démonstration 2', 'description' => 'Deuxième série pour pratiquer sans limite.'],
        ] as $examData) {
            $exam = Exam::create([...$examData, 'is_published' => true]);
            for ($i = 1; $i <= 30; $i++) {
                $exam->questions()->create([
                    'position' => $i,
                    'question_text' => "شنوة يلزمك تعمل في الحالة عدد {$i}؟",
                    'image_path' => 'images/road-sign.svg',
                    'audio_path' => 'https://actions.google.com/sounds/v1/transportation/car_horn.ogg',
                    'options' => ['توقّف وراقب الطريق مليح', 'زيد في السرعة من غير ما تشوف', 'استعمل الهاتف وأنت تسوق'],
                    'correct_option' => 0,
                ]);
            }
        }
    }
}
