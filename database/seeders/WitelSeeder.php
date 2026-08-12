<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Witel;

class WitelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $witels = [
            [
                'name' => 'ACEH',
                'address' => 'Jl. Sultan Iskandar Muda No.18, Banda Aceh',
                'image_path' => 'img/witels/aceh.jpg'
            ],
            [
                'name' => 'BABEL',
                'address' => 'Jl. Jenderal Sudirman No.105, Pangkalpinang',
                'image_path' => 'img/witels/babel.jpg'
            ],
            [
                'name' => 'BENGKULU',
                'address' => 'Jl. Pembangunan No.38, Bengkulu',
                'image_path' => 'img/witels/bengkulu.jpg'
            ],
            [
                'name' => 'JAMBI',
                'address' => 'Jl. Jenderal Sudirman No.55, Jambi',
                'image_path' => 'img/witels/jambi.jpg'
            ],
            [
                'name' => 'LAMPUNG',
                'address' => 'Jl. Wolter Monginsidi No.12, Bandar Lampung',
                'image_path' => 'img/witels/lampung.jpg'
            ],
            [
                'name' => 'RIDAR',
                'address' => 'Jl. Jenderal Sudirman No.199, Pekanbaru',
                'image_path' => 'img/witels/ridar.jpg'
            ],
            [
                'name' => 'RIKEP',
                'address' => 'Jl. Diponegoro No.87, Tanjungpinang',
                'image_path' => 'img/witels/rikep.jpg'
            ],
            [
                'name' => 'SUMBAR',
                'address' => 'Jl. Khatib Sulaiman No.1, Padang',
                'image_path' => 'img/witels/sumbar.jpg'
            ],
            [
                'name' => 'SUMSEL',
                'address' => 'Jl. Jenderal Sudirman No.459, Palembang',
                'image_path' => 'img/witels/sumsel.jpg'
            ],
            [
                'name' => 'SUMUT',
                'address' => 'Jl. Prof. HM. Yamin No.13, Medan',
                'image_path' => 'img/witels/sumut.jpg'
            ],
        ];

        foreach ($witels as $witel) {
            Witel::create($witel);
        }
    }
}