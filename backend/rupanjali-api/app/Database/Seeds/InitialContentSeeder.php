<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialContentSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        /*
         * Portfolio records
         */
        $portfolioItems = [
            [
                'title'      => 'Soft Bridal Glow',
                'category'   => 'Bridal',
                'image'      => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 1,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Timeless Bride',
                'category'   => 'Bridal',
                'image'      => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 2,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Elegant Engagement',
                'category'   => 'Engagement',
                'image'      => 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 3,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Classic Glam',
                'category'   => 'Party',
                'image'      => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 4,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Editorial Beauty',
                'category'   => 'Editorial',
                'image'      => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 5,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Golden Hour',
                'category'   => 'Bridal',
                'image'      => 'https://images.unsplash.com/photo-1524250502761-1ac6f2e30d43?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 6,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Modern Bride',
                'category'   => 'Bridal',
                'image'      => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 7,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Celebration Glam',
                'category'   => 'Party',
                'image'      => 'https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 8,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Romantic Portrait',
                'category'   => 'Engagement',
                'image'      => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 9,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Soft Editorial',
                'category'   => 'Editorial',
                'image'      => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 10,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Natural Beauty',
                'category'   => 'Party',
                'image'      => 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 11,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'The Wedding Look',
                'category'   => 'Bridal',
                'image'      => 'https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 12,
                'status'     => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        /*
         * Service records
         *
         * Includes are stored as JSON because each service can have
         * a different number of included items.
         */
        $services = [
            [
                'title'       => 'Bridal Makeup',
                'subtitle'    => 'For your most unforgettable day',
                'description' => 'A personalised bridal experience designed around your features, outfit, jewellery and wedding aesthetic.',
                'includes'    => json_encode([
                    'Bridal makeup',
                    'Hair styling',
                    'Lashes & finishing',
                    'Long-lasting HD finish',
                ]),
                'duration'    => '3–4 hours',
                'price'       => null,
                'icon'        => 'crown',
                'sort_order'  => 1,
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Engagement Makeup',
                'subtitle'    => 'Elegant. Romantic. You.',
                'description' => 'Soft, polished glam created to photograph beautifully while keeping your natural features at the centre.',
                'includes'    => json_encode([
                    'Makeup application',
                    'Hair styling',
                    'Lashes & finishing',
                    'Look consultation',
                ]),
                'duration'    => '2–3 hours',
                'price'       => null,
                'icon'        => 'heart',
                'sort_order'  => 2,
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Party Makeup',
                'subtitle'    => 'A little more glam',
                'description' => 'From intimate celebrations to grand occasions, choose a look that complements your personality and outfit.',
                'includes'    => json_encode([
                    'Full makeup',
                    'Lashes',
                    'Hair styling',
                    'Finishing & touch-ups',
                ]),
                'duration'    => '1.5–2.5 hours',
                'price'       => null,
                'icon'        => 'sparkles',
                'sort_order'  => 3,
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Photoshoot & Editorial',
                'subtitle'    => 'Camera-ready beauty',
                'description' => 'Makeup designed for photography, fashion, campaigns, portraits and creative productions.',
                'includes'    => json_encode([
                    'Look development',
                    'Makeup application',
                    'Camera-ready finishing',
                    'Look changes on request',
                ]),
                'duration'    => 'Based on project',
                'price'       => null,
                'icon'        => 'camera',
                'sort_order'  => 4,
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('portfolio_items')->insertBatch($portfolioItems);
        $this->db->table('services')->insertBatch($services);
    }
}
