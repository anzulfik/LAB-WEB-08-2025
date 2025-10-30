<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
class HomeController extends Controller
{
    public function index(): view {
        return view('home');
    }
    
    public function destinasi(): View {
        return view('destinasi');
    }

    public function kuliner()
    {
         $foods = [
            [
                'title' => 'Gudeg Jogja',
                'image' => '/images/Gudeg.jpeg',
                'desc' => 'Gudeg menjadi ikon kuliner Yogyakarta — olahan nangka muda yang dimasak lama dengan santan dan gula aren, menghasilkan rasa manis gurih yang khas.'
            ],
            [
                'title' => 'Sate Klathak',
                'image' => '/images/SateKlatak.jpeg',
                'desc' => 'Sate Klathak menggunakan tusuk jeruji besi dan potongan daging kambing muda yang dibakar sederhana, menghasilkan cita rasa gurih autentik dengan sensasi asap menggoda.'
            ],
            [
                'title' => 'Bakpia Pathok',
                'image' => '/images/Bakpia.jpeg',
                'desc' => 'Bakpia Pathok adalah kudapan legendaris berbentuk bulat kecil berisi kacang hijau manis, menjadi oleh-oleh khas yang wajib dibawa pulang dari Yogyakarta.'
            ],
            [
                'title' => 'Wedang Uwuh',
                'image' => '/images/Wedanguwuh.jpeg',
                'desc' => 'Minuman hangat khas Imogiri ini terbuat dari campuran rempah-rempah seperti kayu manis, jahe, dan daun pala, menghasilkan aroma wangi dan rasa pedas manis yang menenangkan.'
            ],
            [
                'title' => 'Oseng Mercon',
                'image' => '/images/Oseng.jpeg',
                'desc' => 'Oseng Mercon adalah masakan pedas legendaris Yogyakarta berisi daging dan tetelan sapi yang dimasak dengan cabai melimpah, menawarkan sensasi pedas yang ‘meledak’ di lidah.'
            ],
            [
                'title' => 'Tiwul',
                'image' => '/images/Tiwul.jpeg',
                'desc' => 'Tiwul berasal dari Gunungkidul, dibuat dari tepung singkong kering (gaplek) dan disajikan dengan kelapa parut serta gula merah — sederhana tapi penuh cita rasa tradisional.'
            ],
        ];

        return view('kuliner', compact('foods'));       
    }

    public function galeri()
    {
         $gallery = [
            ['title'=>'Candi Prambanan','img'=>'/images/candi prambanan.jpeg','tag'=>'Ikonik'],
            ['title'=>'Jalan Malioboro','img'=>'/images/Jalan Malioboro.jpeg','tag'=>'Ikonik'],
            ['title'=>'Keraton Yogyakarta','img'=>'/images/Keraton Jogyakarta.jpeg','tag'=>'Sejarah'],
            ['title'=>'Taman Sari','img'=>'/images/Taman sari.jpeg','tag'=>'Romantis'],
            ['title'=>'Pantai Jungwok','img'=>'/images/Pantai Jungwok.jpeg','tag'=>'Eksotis'],
            ['title'=>'Prambanan Jazz Festival','img'=>'/images/prambanjazz.jpeg','tag'=>'Event'],
            ['title'=>'Tugu Jogja','img'=>'/images/Tugu Jogja.jpeg','tag'=>'Ikonik'],
            ['title'=>'Batik Yogyakarta','img'=>'/images/Batik.jpeg','tag'=>'Budaya'],
        ];
        return view('galeri', compact('gallery'));    
    }

    public function event() 
    {
        // Data dummy (dipindahkan dari Blade)
        $events = [
            [
                'title' => 'Festival Sekaten',
                'image' => 'images/sakaten.jpeg',
                'tags'  => ['Tradisi', 'Keraton'],
                'desc'  => 'Festival Sekaten merupakan perayaan budaya tahunan yang digelar di Alun-Alun Utara Keraton Yogyakarta untuk memperingati kelahiran Nabi Muhammad SAW. Suara gamelan Sekaten mengalun syahdu, diiringi kemeriahan pasar malam dan ritual adat penuh makna.'
            ],
            [
                'title' => 'Pramban Jazz Festival',
                'image' => 'images/prambanjazz.jpeg',
                'tags'  => ['Jazz', 'Candi'],
                'desc'  => 'Kolaborasi antara musik modern dan warisan sejarah. Konser jazz megah berlatar kemegahan Candi Prambanan dengan tata cahaya memukau.'
            ],
        ];

        // Kirim ke view
        return view('event', compact('events'));  
    }

    public function tentang(): View {
        return view('tentang');
    }

    public function kontak(): View {
        return view('kontak');
    }



}