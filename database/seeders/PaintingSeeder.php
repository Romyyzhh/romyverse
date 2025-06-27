<?php

namespace Database\Seeders;

use App\Models\Painting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaintingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paintings = [
            [
                'title' => 'Starry Night',
                'artist' => 'Vincent van Gogh',
                'year' => 1889,
                'description' => 'The Starry Night is an oil-on-canvas painting by the Dutch Post-Impressionist painter Vincent van Gogh.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg/1200px-Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg',
                'user_id' => 1,
            ],
            [
                'title' => 'The Persistence of Memory',
                'artist' => 'Salvador Dalí',
                'year' => 1931,
                'description' => 'The Persistence of Memory is a 1931 painting by artist Salvador Dalí and one of the most recognizable works of Surrealism.',
                'image_url' => 'https://uploads6.wikiart.org/images/salvador-dali/the-persistence-of-memory-1931.jpg',
                'user_id' => 1,
            ],
            [
                'title' => 'The Scream',
                'artist' => 'Edvard Munch',
                'year' => 1893,
                'description' => 'The Scream is the popular name given to a composition created by Norwegian Expressionist artist Edvard Munch in 1893.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Edvard_Munch%2C_1893%2C_The_Scream%2C_oil%2C_tempera_and_pastel_on_cardboard%2C_91_x_73_cm%2C_National_Gallery_of_Norway.jpg/1200px-Edvard_Munch%2C_1893%2C_The_Scream%2C_oil%2C_tempera_and_pastel_on_cardboard%2C_91_x_73_cm%2C_National_Gallery_of_Norway.jpg',
                'user_id' => 1,
            ],
            [
                'title' => 'Girl with a Pearl Earring',
                'artist' => 'Johannes Vermeer',
                'year' => 1665,
                'description' => 'Girl with a Pearl Earring is an oil painting by Dutch Golden Age painter Johannes Vermeer, dated c. 1665.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/1665_Girl_with_a_Pearl_Earring.jpg/800px-1665_Girl_with_a_Pearl_Earring.jpg',
                'user_id' => 1,
            ],
            [
                'title' => 'The Night Watch',
                'artist' => 'Rembrandt',
                'year' => 1642,
                'description' => 'The Night Watch is a 1642 painting by Rembrandt van Rijn. It is in the collection of the Amsterdam Museum but is prominently displayed in the Rijksmuseum.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/The_Night_Watch_-_HD.jpg/1200px-The_Night_Watch_-_HD.jpg',
                'user_id' => 1,
            ],
        ];

        foreach ($paintings as $painting) {
            Painting::create($painting);
        }
    }
}
