<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

class PageController extends Controller
{
    public function home() {
        return view('home');
    }

    public function destinasi() {
        return view('destinasi');
    }

    public function kuliner() {
        $menus = [
                    [
                        'img' => 'parape.jpg',
                        'title' => 'Ikan Parape',
                        'desc' => 'Hidangan ikan bakar khas Sulawesi Selatan dengan sambal parape — campuran bawang, tomat, dan cabai goreng. Rasanya pedas, segar, dan gurih, nikmat disantap dengan nasi hangat.',
                        'badge' => 'Pake nasiki!',
                        'color' => 'border-l-4 border-l-orange-500'
                    ],
                    [
                        'img' => 'barobbo.jpg',
                        'title' => 'Barobbo',
                        'desc' => 'Masakan tradisional berbahan dasar jagung muda yang dimasak seperti bubur dengan ikan atau udang. Teksturnya lembut dan gurih, pas dinikmati sore hari.',
                        'badge' => 'Pake cukka enak!',
                        'color' => 'border-l-4 border-l-amber-500'
                    ],
                    [
                        'img' => 'uhu-uhu.jpg',
                        'title' => 'Uhu-Uhu',
                        'desc' => 'Kuliner pesisir Bulukumba dari ikan segar dimasak dengan bumbu kuning dan santan. Rasa gurih dan sedikit asam menggambarkan cita rasa khas laut Sulawesi Selatan.',
                        'badge' => '',
                        'color' => 'border-l-4 border-l-blue-500'
                    ],
                    [
                        'img' => 'songkolo.jpg',
                        'title' => 'Songkolo',
                        'desc' => 'Nasi ketan hitam atau putih yang dikukus dan disajikan dengan parutan kelapa serta ikan asin. Biasanya disantap saat pagi hari atau pada acara keluarga.',
                        'badge' => '',
                        'color' => 'border-l-4 border-l-purple-500'
                    ],
                    [
                        'img' => 'paranggi.jpg',
                        'title' => 'Paranggi',
                        'desc' => 'Kue tradisional Bulukumba dari tepung terigu, gula merah, dan santan yang digoreng hingga kecokelatan. Rasanya manis legit, cocok untuk teman minum kopi.',
                        'badge' => 'Cocok buat oleh-oleh!',
                        'color' => 'border-l-4 border-l-pink-500'
                    ],
                    [
                        'img' => 'barongko.jpg',
                        'title' => 'Barongko',
                        'desc' => 'Kue lembut berbahan pisang yang dihaluskan, dicampur santan dan telur, dibungkus daun pisang lalu dikukus. Hidangan adat Bugis-Makassar simbol kehangatan keluarga.',
                        'badge' => '',
                        'color' => 'border-l-4 border-l-green-500'
                    ]
                ];
           

       return view('kuliner', compact('menus'));

    }

    public function event() {
        return view('event');
    }

    public function galeri() 
    {
        $galeri = [
            ['images/bira.jpg', 'Pantai Tanjung Bira', 'Destinasi', 'cyan'],
            ['images/apparalang.jpg', 'Tebing Apparalang', 'Destinasi', 'teal'],
            ['images/ammatoa.jpg', 'Desa Ammatoa Kajang', 'Destinasi', 'amber'],
            ['images/panrangluhu.jpg', 'Pantai Panrang Luhu', 'Destinasi', 'sky'],
            ['images/lemo-lemo.jpg', 'Pantai Lemo-Lemo', 'Destinasi', 'blue'],
            ['images/bara.jpg', 'Pantai Bara', 'Destinasi', 'cyan'],
            ['images/titikNol.jpg', 'Titik Nol', 'Destinasi', 'purple'],
            ['images/parape.jpg', 'Ikan Parape', 'Kuliner', 'rose'],
            ['images/barobbo.jpg', 'Barobbo', 'Kuliner', 'orange'],
            ['images/songkolo.jpg', 'Songkolo', 'Kuliner', 'yellow'],
            ['images/barongko.jpg', 'Barongko', 'Kuliner', 'amber'],
            ['images/paranggi.jpg', 'Paranggi', 'Kuliner', 'lime'],
            ['images/uhu-uhu.jpg', 'Uhu-Uhu', 'Kuliner', 'emerald'],
            ['images/pinisi_festival.jpg', 'Festival Pinisi', 'Event', 'indigo'],
            ['images/ammatoa_festival.jpg', 'Festival Adat Ammatoa Kajang', 'Event', 'violet'],
            ['images/expo_kreatif.jpg', 'Expo Kreatif Bulukumba', 'Event', 'fuchsia'],
        ];

            $rows = [
            array_slice($galeri, 0, 4),
            array_slice($galeri, 4, 4),
            array_slice($galeri, 8, 4),
            array_slice($galeri, 12, 2),
        ];
  

        return view('galeri', compact('galeri', 'rows'));

    }

    public function peta() {
        return view('peta');
    }

    public function kontak() {
        return view('kontak');
    }
}
