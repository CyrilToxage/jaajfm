<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MusicGenre;
use Illuminate\Support\Str;

class MusicGenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            // MUSIQUE CLASSIQUE ET SAVANTE
            [
                'name' => 'Musique Classique et Savante',
                'color' => '#1E40AF',
                'children' => [
                    [
                        'name' => 'Musique médiévale',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Grégorien', 'color' => '#60A5FA'],
                            ['name' => 'Organum', 'color' => '#60A5FA'],
                            ['name' => 'Ars Nova', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Renaissance',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Madrigal', 'color' => '#60A5FA'],
                            ['name' => 'Chanson', 'color' => '#60A5FA'],
                            ['name' => 'Motet', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Baroque',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Concerto', 'color' => '#60A5FA'],
                            ['name' => 'Fugue', 'color' => '#60A5FA'],
                            ['name' => 'Suite', 'color' => '#60A5FA'],
                            ['name' => 'Oratorio', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Classique',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Sonate', 'color' => '#60A5FA'],
                            ['name' => 'Symphonie', 'color' => '#60A5FA'],
                            ['name' => 'Quatuor', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Romantique',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Lied', 'color' => '#60A5FA'],
                            ['name' => 'Poème symphonique', 'color' => '#60A5FA'],
                        ]
                    ],
                    ['name' => 'Impressionnisme', 'color' => '#3B82F6'],
                    [
                        'name' => 'Musique du XXe siècle',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Dodécaphonisme', 'color' => '#60A5FA'],
                            ['name' => 'Sérialisme', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Musique contemporaine',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Spectrale', 'color' => '#60A5FA'],
                            ['name' => 'Électroacoustique', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Opéra',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Opera seria', 'color' => '#60A5FA'],
                            ['name' => 'Opera buffa', 'color' => '#60A5FA'],
                            ['name' => 'Grand opéra', 'color' => '#60A5FA'],
                        ]
                    ],
                    ['name' => 'Musique de chambre', 'color' => '#3B82F6'],
                    [
                        'name' => 'Musique sacrée',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Messe', 'color' => '#60A5FA'],
                            ['name' => 'Requiem', 'color' => '#60A5FA'],
                            ['name' => 'Te Deum', 'color' => '#60A5FA'],
                        ]
                    ],
                    ['name' => 'Musique symphonique', 'color' => '#3B82F6'],
                    [
                        'name' => 'Concerto',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Solo', 'color' => '#60A5FA'],
                            ['name' => 'Grosso', 'color' => '#60A5FA'],
                        ]
                    ],
                    [
                        'name' => 'Musique vocale',
                        'color' => '#3B82F6',
                        'children' => [
                            ['name' => 'Oratorio', 'color' => '#60A5FA'],
                            ['name' => 'Cantate', 'color' => '#60A5FA'],
                            ['name' => 'Lied', 'color' => '#60A5FA'],
                        ]
                    ],
                ]
            ],

            // JAZZ ET MUSIQUES IMPROVISÉES
            [
                'name' => 'Jazz et Musiques Improvisées',
                'color' => '#DC2626',
                'children' => [
                    ['name' => 'Dixieland', 'color' => '#EF4444'],
                    ['name' => 'Swing', 'color' => '#EF4444'],
                    ['name' => 'Bebop', 'color' => '#EF4444'],
                    ['name' => 'Cool Jazz', 'color' => '#EF4444'],
                    ['name' => 'Hard Bop', 'color' => '#EF4444'],
                    ['name' => 'Free Jazz', 'color' => '#EF4444'],
                    ['name' => 'Fusion', 'color' => '#EF4444'],
                    ['name' => 'Smooth Jazz', 'color' => '#EF4444'],
                    ['name' => 'Acid Jazz', 'color' => '#EF4444'],
                    ['name' => 'Nu Jazz', 'color' => '#EF4444'],
                    ['name' => 'Jazz Manouche', 'color' => '#EF4444'],
                    [
                        'name' => 'Latin Jazz',
                        'color' => '#EF4444',
                        'children' => [
                            ['name' => 'Bossa Nova', 'color' => '#F87171'],
                            ['name' => 'Afro-Cuban', 'color' => '#F87171'],
                        ]
                    ],
                    ['name' => 'Modal Jazz', 'color' => '#EF4444'],
                    ['name' => 'Post-Bop', 'color' => '#EF4444'],
                    ['name' => 'Jazz Funk', 'color' => '#EF4444'],
                    ['name' => 'Spiritual Jazz', 'color' => '#EF4444'],
                    ['name' => 'European Jazz', 'color' => '#EF4444'],
                    ['name' => 'Contemporary Jazz', 'color' => '#EF4444'],
                ]
            ],

            // BLUES ET DÉRIVÉS
            [
                'name' => 'Blues et Dérivés',
                'color' => '#7C3AED',
                'children' => [
                    ['name' => 'Delta Blues', 'color' => '#A855F7'],
                    ['name' => 'Chicago Blues', 'color' => '#A855F7'],
                    ['name' => 'Electric Blues', 'color' => '#A855F7'],
                    ['name' => 'Acoustic Blues', 'color' => '#A855F7'],
                    ['name' => 'Piedmont Blues', 'color' => '#A855F7'],
                    ['name' => 'Texas Blues', 'color' => '#A855F7'],
                    ['name' => 'West Coast Blues', 'color' => '#A855F7'],
                    ['name' => 'British Blues', 'color' => '#A855F7'],
                    ['name' => 'Blues Rock', 'color' => '#A855F7'],
                    ['name' => 'Rhythm and Blues (R&B)', 'color' => '#A855F7'],
                    ['name' => 'Jump Blues', 'color' => '#A855F7'],
                    ['name' => 'Boogie Woogie', 'color' => '#A855F7'],
                ]
            ],

            // ROCK ET METAL
            [
                'name' => 'Rock et Metal',
                'color' => '#B91C1C',
                'children' => [
                    ['name' => 'Rock \'n\' Roll', 'color' => '#DC2626'],
                    ['name' => 'Rockabilly', 'color' => '#DC2626'],
                    ['name' => 'Surf Rock', 'color' => '#DC2626'],
                    ['name' => 'Garage Rock', 'color' => '#DC2626'],
                    ['name' => 'Psychedelic Rock', 'color' => '#DC2626'],
                    ['name' => 'Progressive Rock', 'color' => '#DC2626'],
                    ['name' => 'Art Rock', 'color' => '#DC2626'],
                    ['name' => 'Glam Rock', 'color' => '#DC2626'],
                    ['name' => 'Hard Rock', 'color' => '#DC2626'],
                    ['name' => 'Arena Rock', 'color' => '#DC2626'],
                    ['name' => 'Southern Rock', 'color' => '#DC2626'],
                    ['name' => 'Heartland Rock', 'color' => '#DC2626'],
                    ['name' => 'Indie Rock', 'color' => '#DC2626'],
                    ['name' => 'Alternative Rock', 'color' => '#DC2626'],
                    ['name' => 'Grunge', 'color' => '#DC2626'],
                    ['name' => 'Britpop', 'color' => '#DC2626'],
                    ['name' => 'Post-Rock', 'color' => '#DC2626'],
                    ['name' => 'Math Rock', 'color' => '#DC2626'],
                    ['name' => 'Noise Rock', 'color' => '#DC2626'],
                    ['name' => 'Shoegaze', 'color' => '#DC2626'],
                    ['name' => 'Dream Pop', 'color' => '#DC2626'],
                    ['name' => 'Heavy Metal', 'color' => '#991B1B'],
                    ['name' => 'Thrash Metal', 'color' => '#991B1B'],
                    ['name' => 'Death Metal', 'color' => '#991B1B'],
                    ['name' => 'Black Metal', 'color' => '#991B1B'],
                    ['name' => 'Power Metal', 'color' => '#991B1B'],
                    ['name' => 'Progressive Metal', 'color' => '#991B1B'],
                    ['name' => 'Doom Metal', 'color' => '#991B1B'],
                    ['name' => 'Sludge Metal', 'color' => '#991B1B'],
                    ['name' => 'Stoner Rock/Metal', 'color' => '#991B1B'],
                    ['name' => 'Nu Metal', 'color' => '#991B1B'],
                    ['name' => 'Metalcore', 'color' => '#991B1B'],
                    ['name' => 'Deathcore', 'color' => '#991B1B'],
                    ['name' => 'Symphonic Metal', 'color' => '#991B1B'],
                    ['name' => 'Folk Metal', 'color' => '#991B1B'],
                    ['name' => 'Viking Metal', 'color' => '#991B1B'],
                    ['name' => 'Industrial Metal', 'color' => '#991B1B'],
                    ['name' => 'Gothic Metal', 'color' => '#991B1B'],
                    ['name' => 'Atmospheric Metal', 'color' => '#991B1B'],
                    ['name' => 'Post-Metal', 'color' => '#991B1B'],
                ]
            ],

            // MUSIQUES ÉLECTRONIQUES
            [
                'name' => 'Musiques Électroniques',
                'color' => '#059669',
                'children' => [
                    ['name' => 'Disco', 'color' => '#10B981'],
                    [
                        'name' => 'House',
                        'color' => '#10B981',
                        'children' => [
                            ['name' => 'Deep House', 'color' => '#34D399'],
                            ['name' => 'Tech House', 'color' => '#34D399'],
                            ['name' => 'Progressive House', 'color' => '#34D399'],
                            ['name' => 'Electro House', 'color' => '#34D399'],
                        ]
                    ],
                    [
                        'name' => 'Techno',
                        'color' => '#10B981',
                        'children' => [
                            ['name' => 'Detroit Techno', 'color' => '#34D399'],
                            ['name' => 'Minimal Techno', 'color' => '#34D399'],
                            ['name' => 'Hard Techno', 'color' => '#34D399'],
                        ]
                    ],
                    [
                        'name' => 'Trance',
                        'color' => '#10B981',
                        'children' => [
                            ['name' => 'Uplifting Trance', 'color' => '#34D399'],
                            ['name' => 'Progressive Trance', 'color' => '#34D399'],
                            ['name' => 'Psytrance', 'color' => '#34D399'],
                        ]
                    ],
                    [
                        'name' => 'Drum and Bass',
                        'color' => '#10B981',
                        'children' => [
                            ['name' => 'Jungle', 'color' => '#34D399'],
                            ['name' => 'Liquid DnB', 'color' => '#34D399'],
                            ['name' => 'Neurofunk', 'color' => '#34D399'],
                        ]
                    ],
                    ['name' => 'Dubstep', 'color' => '#10B981'],
                    ['name' => 'UK Garage', 'color' => '#10B981'],
                    ['name' => 'Breakbeat', 'color' => '#10B981'],
                    ['name' => 'Big Beat', 'color' => '#10B981'],
                    [
                        'name' => 'Hardcore',
                        'color' => '#10B981',
                        'children' => [
                            ['name' => 'Gabber', 'color' => '#34D399'],
                            ['name' => 'Happy Hardcore', 'color' => '#34D399'],
                        ]
                    ],
                    ['name' => 'Hardstyle', 'color' => '#10B981'],
                    ['name' => 'EDM (Electronic Dance Music)', 'color' => '#10B981'],
                    ['name' => 'Ambient', 'color' => '#10B981'],
                    ['name' => 'IDM (Intelligent Dance Music)', 'color' => '#10B981'],
                    ['name' => 'Glitch', 'color' => '#10B981'],
                    ['name' => 'Minimal', 'color' => '#10B981'],
                    ['name' => 'Drone', 'color' => '#10B981'],
                    ['name' => 'Dark Ambient', 'color' => '#10B981'],
                    ['name' => 'Musique Concrète', 'color' => '#10B981'],
                    ['name' => 'Électroacoustique', 'color' => '#10B981'],
                    ['name' => 'Noise', 'color' => '#10B981'],
                    ['name' => 'Industrial', 'color' => '#10B981'],
                    ['name' => 'EBM (Electronic Body Music)', 'color' => '#10B981'],
                    ['name' => 'Synthwave/Retrowave', 'color' => '#10B981'],
                    ['name' => 'Vaporwave', 'color' => '#10B981'],
                    ['name' => 'Chillwave', 'color' => '#10B981'],
                ]
            ],

            // POP ET MUSIQUES POPULAIRES
            [
                'name' => 'Pop et Musiques Populaires',
                'color' => '#EC4899',
                'children' => [
                    ['name' => 'Pop Rock', 'color' => '#F472B6'],
                    ['name' => 'Teen Pop', 'color' => '#F472B6'],
                    ['name' => 'Dance Pop', 'color' => '#F472B6'],
                    ['name' => 'Electropop', 'color' => '#F472B6'],
                    ['name' => 'Synthpop', 'color' => '#F472B6'],
                    ['name' => 'New Wave', 'color' => '#F472B6'],
                    ['name' => 'Post-Punk', 'color' => '#F472B6'],
                    ['name' => 'Indie Pop', 'color' => '#F472B6'],
                    ['name' => 'Dream Pop', 'color' => '#F472B6'],
                    ['name' => 'Chamber Pop', 'color' => '#F472B6'],
                    ['name' => 'Art Pop', 'color' => '#F472B6'],
                    ['name' => 'Experimental Pop', 'color' => '#F472B6'],
                    ['name' => 'K-Pop', 'color' => '#F472B6'],
                    ['name' => 'J-Pop', 'color' => '#F472B6'],
                    ['name' => 'Europop', 'color' => '#F472B6'],
                    ['name' => 'Latin Pop', 'color' => '#F472B6'],
                ]
            ],

            // HIP-HOP ET RAP
            [
                'name' => 'Hip-Hop et Rap',
                'color' => '#F59E0B',
                'children' => [
                    ['name' => 'Old School Hip-Hop', 'color' => '#FBBF24'],
                    ['name' => 'Boom Bap', 'color' => '#FBBF24'],
                    ['name' => 'East Coast Hip-Hop', 'color' => '#FBBF24'],
                    ['name' => 'West Coast Hip-Hop', 'color' => '#FBBF24'],
                    ['name' => 'Southern Hip-Hop (Dirty South)', 'color' => '#FBBF24'],
                    ['name' => 'Gangsta Rap', 'color' => '#FBBF24'],
                    ['name' => 'Conscious Rap', 'color' => '#FBBF24'],
                    ['name' => 'Alternative Hip-Hop', 'color' => '#FBBF24'],
                    ['name' => 'Jazz Rap', 'color' => '#FBBF24'],
                    ['name' => 'Trap', 'color' => '#FBBF24'],
                    ['name' => 'Mumble Rap', 'color' => '#FBBF24'],
                    ['name' => 'Cloud Rap', 'color' => '#FBBF24'],
                    ['name' => 'Drill', 'color' => '#FBBF24'],
                    ['name' => 'Grime', 'color' => '#FBBF24'],
                    ['name' => 'UK Hip-Hop', 'color' => '#FBBF24'],
                    ['name' => 'French Rap', 'color' => '#FBBF24'],
                    ['name' => 'Horrorcore', 'color' => '#FBBF24'],
                    ['name' => 'Christian Hip-Hop', 'color' => '#FBBF24'],
                ]
            ],

            // MUSIQUES DU MONDE
            [
                'name' => 'Musiques du Monde',
                'color' => '#16A34A',
                'children' => [
                    ['name' => 'Afrobeat', 'color' => '#22C55E'],
                    ['name' => 'Highlife', 'color' => '#22C55E'],
                    ['name' => 'Soukous', 'color' => '#22C55E'],
                    ['name' => 'Mbalax', 'color' => '#22C55E'],
                    ['name' => 'Rai', 'color' => '#22C55E'],
                    ['name' => 'Gnawa', 'color' => '#22C55E'],
                    ['name' => 'Makossa', 'color' => '#22C55E'],
                    ['name' => 'Kizomba', 'color' => '#22C55E'],
                    ['name' => 'Amapiano', 'color' => '#22C55E'],
                    ['name' => 'Bongo Flava', 'color' => '#22C55E'],
                    ['name' => 'Salsa', 'color' => '#22C55E'],
                    ['name' => 'Merengue', 'color' => '#22C55E'],
                    ['name' => 'Bachata', 'color' => '#22C55E'],
                    ['name' => 'Reggaeton', 'color' => '#22C55E'],
                    ['name' => 'Cumbia', 'color' => '#22C55E'],
                    ['name' => 'Vallenato', 'color' => '#22C55E'],
                    ['name' => 'Tango', 'color' => '#22C55E'],
                    ['name' => 'Bossa Nova', 'color' => '#22C55E'],
                    ['name' => 'Samba', 'color' => '#22C55E'],
                    ['name' => 'Forró', 'color' => '#22C55E'],
                    ['name' => 'Mariachi', 'color' => '#22C55E'],
                    ['name' => 'Ranchera', 'color' => '#22C55E'],
                    ['name' => 'Nueva Canción', 'color' => '#22C55E'],
                    ['name' => 'Reggae', 'color' => '#22C55E'],
                    ['name' => 'Dancehall', 'color' => '#22C55E'],
                    ['name' => 'Ska', 'color' => '#22C55E'],
                    ['name' => 'Rocksteady', 'color' => '#22C55E'],
                    ['name' => 'Dub', 'color' => '#22C55E'],
                    ['name' => 'Soca', 'color' => '#22C55E'],
                    ['name' => 'Calypso', 'color' => '#22C55E'],
                    ['name' => 'Zouk', 'color' => '#22C55E'],
                    ['name' => 'Kompas', 'color' => '#22C55E'],
                    ['name' => 'Raga (Musique classique indienne)', 'color' => '#22C55E'],
                    ['name' => 'Qawwali', 'color' => '#22C55E'],
                    ['name' => 'Bollywood', 'color' => '#22C55E'],
                    ['name' => 'Gamelan', 'color' => '#22C55E'],
                    ['name' => 'Taiko', 'color' => '#22C55E'],
                    ['name' => 'Gagaku', 'color' => '#22C55E'],
                    ['name' => 'Pansori', 'color' => '#22C55E'],
                    ['name' => 'Chinese Opera', 'color' => '#22C55E'],
                    ['name' => 'Flamenco', 'color' => '#22C55E'],
                    ['name' => 'Fado', 'color' => '#22C55E'],
                    [
                        'name' => 'Celtic',
                        'color' => '#22C55E',
                        'children' => [
                            ['name' => 'Irish Folk', 'color' => '#4ADE80'],
                            ['name' => 'Scottish Folk', 'color' => '#4ADE80'],
                        ]
                    ],
                    ['name' => 'Klezmer', 'color' => '#22C55E'],
                    ['name' => 'Chanson Française', 'color' => '#22C55E'],
                    ['name' => 'Schlager', 'color' => '#22C55E'],
                    ['name' => 'Volksmuziek', 'color' => '#22C55E'],
                    ['name' => 'Rebetiko', 'color' => '#22C55E'],
                ]
            ],

            // COUNTRY ET FOLK
            [
                'name' => 'Country et Folk',
                'color' => '#D97706',
                'children' => [
                    ['name' => 'Bluegrass', 'color' => '#F59E0B'],
                    ['name' => 'Honky Tonk', 'color' => '#F59E0B'],
                    ['name' => 'Outlaw Country', 'color' => '#F59E0B'],
                    ['name' => 'Nashville Sound', 'color' => '#F59E0B'],
                    ['name' => 'Country Rock', 'color' => '#F59E0B'],
                    ['name' => 'Alt-Country', 'color' => '#F59E0B'],
                    ['name' => 'Americana', 'color' => '#F59E0B'],
                    ['name' => 'Western Swing', 'color' => '#F59E0B'],
                    ['name' => 'Country Pop', 'color' => '#F59E0B'],
                    ['name' => 'Traditional Folk', 'color' => '#F59E0B'],
                    ['name' => 'Contemporary Folk', 'color' => '#F59E0B'],
                    ['name' => 'Folk Rock', 'color' => '#F59E0B'],
                    ['name' => 'Folk Revival', 'color' => '#F59E0B'],
                    ['name' => 'Protest Songs', 'color' => '#F59E0B'],
                    ['name' => 'Singer-Songwriter', 'color' => '#F59E0B'],
                    ['name' => 'Anti-Folk', 'color' => '#F59E0B'],
                    ['name' => 'Freak Folk', 'color' => '#F59E0B'],
                    ['name' => 'New Weird America', 'color' => '#F59E0B'],
                ]
            ],

            // MUSIQUE RELIGIEUSE ET SPIRITUELLE
            [
                'name' => 'Musique Religieuse et Spirituelle',
                'color' => '#7C2D12',
                'children' => [
                    ['name' => 'Gospel', 'color' => '#A16207'],
                    ['name' => 'Contemporary Christian', 'color' => '#A16207'],
                    ['name' => 'Christian Rock', 'color' => '#A16207'],
                    ['name' => 'Christian Metal', 'color' => '#A16207'],
                    ['name' => 'Spiritual', 'color' => '#A16207'],
                    ['name' => 'Negro Spiritual', 'color' => '#A16207'],
                    ['name' => 'Hymnes', 'color' => '#A16207'],
                    ['name' => 'Musique Soufie', 'color' => '#A16207'],
                    ['name' => 'Chants Bouddhistes', 'color' => '#A16207'],
                    ['name' => 'Kirtan', 'color' => '#A16207'],
                    ['name' => 'Musique Sacrée Juive', 'color' => '#A16207'],
                    ['name' => 'Chants Grégoriens', 'color' => '#A16207'],
                ]
            ],

            // MUSIQUES EXPÉRIMENTALES ET AVANT-GARDE
            [
                'name' => 'Musiques Expérimentales et Avant-Garde',
                'color' => '#6B7280',
                'children' => [
                    ['name' => 'Musique Bruitiste', 'color' => '#9CA3AF'],
                    ['name' => 'Minimalisme', 'color' => '#9CA3AF'],
                    ['name' => 'Musique Répétitive', 'color' => '#9CA3AF'],
                    ['name' => 'Drone Music', 'color' => '#9CA3AF'],
                    ['name' => 'Field Recording', 'color' => '#9CA3AF'],
                    ['name' => 'Sound Art', 'color' => '#9CA3AF'],
                    ['name' => 'Plunderphonics', 'color' => '#9CA3AF'],
                    ['name' => 'Lowercase', 'color' => '#9CA3AF'],
                    ['name' => 'Microsound', 'color' => '#9CA3AF'],
                    ['name' => 'Acousmatic Music', 'color' => '#9CA3AF'],
                ]
            ],

            // MUSIQUES DE FILMS ET MÉDIAS
            [
                'name' => 'Musiques de Films et Médias',
                'color' => '#1F2937',
                'children' => [
                    ['name' => 'Musique de Film', 'color' => '#4B5563'],
                    ['name' => 'Musique de Jeux Vidéo', 'color' => '#4B5563'],
                    ['name' => 'Musique de Télévision', 'color' => '#4B5563'],
                    ['name' => 'Library Music', 'color' => '#4B5563'],
                    ['name' => 'Easy Listening', 'color' => '#4B5563'],
                    ['name' => 'Lounge', 'color' => '#4B5563'],
                    ['name' => 'Elevator Music', 'color' => '#4B5563'],
                    ['name' => 'New Age', 'color' => '#4B5563'],
                ]
            ],

            // FUSION ET HYBRIDES
            [
                'name' => 'Fusion et Hybrides',
                'color' => '#8B5CF6',
                'children' => [
                    ['name' => 'Jazz Fusion', 'color' => '#A855F7'],
                    ['name' => 'Rock Fusion', 'color' => '#A855F7'],
                    ['name' => 'World Fusion', 'color' => '#A855F7'],
                    ['name' => 'Electro-Acoustic', 'color' => '#A855F7'],
                    ['name' => 'Nu-Disco', 'color' => '#A855F7'],
                    ['name' => 'Folktronica', 'color' => '#A855F7'],
                    ['name' => 'Post-Genre', 'color' => '#A855F7'],
                    ['name' => 'Crossover', 'color' => '#A855F7'],
                    ['name' => 'Third Stream', 'color' => '#A855F7'],
                ]
            ],
        ];

        $this->createGenres($genres);
    }

    private function createGenres(array $genres, ?MusicGenre $parent = null, int $order = 0): void
    {
        foreach ($genres as $genreData) {
            $genre = MusicGenre::create([
                'name' => $genreData['name'],
                'slug' => MusicGenre::generateSlug($genreData['name']),
                'color' => $genreData['color'],
                'parent_id' => $parent?->id,
                'order' => $order++,
                'is_active' => true,
            ]);

            if (isset($genreData['children'])) {
                $this->createGenres($genreData['children'], $genre, 0);
            }
        }
    }
}
