<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Plot;
use App\Models\User;
use App\Models\Burial;
use App\Models\PreNeedPlan;
use App\Models\ColumbaryNiche;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'admin',
            ]);
        }

        $this->call(BurialSpotSeeder::class);

        if (PreNeedPlan::count() === 0) {
            PreNeedPlan::insert([
                ['name' => 'Garden Memorial Plan', 'slug' => 'garden-memorial-plan', 'type' => 'memorial', 'description' => 'A peaceful garden memorial package with perpetual care and maintenance.', 'features' => json_encode(['Garden lot with marker', 'Perpetual care', 'Annual memorial service', 'Online memorial page', '24/7 security']), 'price' => 45000, 'is_active' => true],
                ['name' => 'Family Legacy Plan', 'slug' => 'family-legacy-plan', 'type' => 'burial', 'description' => 'A comprehensive family estate package for up to 4 occupants with premium services.', 'features' => json_encode(['Family estate lot (up to 4)', 'Premium granite marker', 'Perpetual care & maintenance', 'Annual memorial service', 'Online memorial page', '24/7 security & CCTV', 'Private family viewing area']), 'price' => 120000, 'is_active' => true],
                ['name' => 'Columbary Peace Plan', 'slug' => 'columbary-peace-plan', 'type' => 'memorial', 'description' => 'A dignified columbary niche package with eternal care and remembrance services.', 'features' => json_encode(['Columbary niche', 'Brass name plate', 'Perpetual care', 'Annual remembrance service', 'Online memorial page']), 'price' => 25000, 'is_active' => true],
                ['name' => 'Funeral Service Package', 'slug' => 'funeral-service-package', 'type' => 'funeral', 'description' => 'Complete funeral service package including wake, chapel, and burial coordination.', 'features' => json_encode(['Chapel rental (3 days)', 'Hearse service', 'Casket (basic)', 'Embalming & sanitation', 'Memorial program booklets', 'Burial coordination']), 'price' => 85000, 'is_active' => true],
            ]);
        }

        if (ColumbaryNiche::count() === 0) {
            ColumbaryNiche::insert([
                ['niche_number' => 'CN-A01', 'section' => 'Garden A', 'row' => '1', 'tier' => 1, 'status' => 'available', 'price' => 15000, 'map_x' => 50, 'map_y' => 50],
                ['niche_number' => 'CN-A02', 'section' => 'Garden A', 'row' => '1', 'tier' => 2, 'status' => 'available', 'price' => 15000, 'map_x' => 50, 'map_y' => 100],
                ['niche_number' => 'CN-A03', 'section' => 'Garden A', 'row' => '1', 'tier' => 3, 'status' => 'available', 'price' => 15000, 'map_x' => 50, 'map_y' => 150],
                ['niche_number' => 'CN-B01', 'section' => 'Garden B', 'row' => '2', 'tier' => 1, 'status' => 'available', 'price' => 18000, 'map_x' => 150, 'map_y' => 50],
                ['niche_number' => 'CN-B02', 'section' => 'Garden B', 'row' => '2', 'tier' => 2, 'status' => 'available', 'price' => 18000, 'map_x' => 150, 'map_y' => 100],
                ['niche_number' => 'CN-B03', 'section' => 'Garden B', 'row' => '2', 'tier' => 3, 'status' => 'occupied', 'price' => 18000, 'map_x' => 150, 'map_y' => 150],
            ]);
        }

        if (Plot::count() === 0) {
            Plot::insert([
                ['plot_number' => 'A-01', 'section' => 'Block 1', 'lat' => 14.9544, 'lng' => 120.9006, 'capacity' => 1, 'current_occupants' => 1, 'status' => 'occupied', 'price' => 25000],
                ['plot_number' => 'A-02', 'section' => 'Block 1', 'lat' => 14.9546, 'lng' => 120.9009, 'capacity' => 1, 'current_occupants' => 1, 'status' => 'occupied', 'price' => 25000],
                ['plot_number' => 'B-01', 'section' => 'Block 2', 'lat' => 14.9549, 'lng' => 120.9012, 'capacity' => 2, 'current_occupants' => 0, 'status' => 'available', 'price' => 35000],
                ['plot_number' => 'B-02', 'section' => 'Block 2', 'lat' => 14.9547, 'lng' => 120.9015, 'capacity' => 2, 'current_occupants' => 0, 'status' => 'available', 'price' => 35000],
                ['plot_number' => 'C-01', 'section' => 'Block 3', 'lat' => 14.9550, 'lng' => 120.9018, 'capacity' => 1, 'current_occupants' => 0, 'status' => 'available', 'price' => 20000],
            ]);
        }

        if (Client::count() === 0) {
            Client::insert([
                ['full_name' => 'Juan Dela Cruz', 'contact_number' => '09171234567', 'email' => 'juan@example.com', 'address' => '123 Rizal St, Baliuag, Bulacan', 'id_number' => '1234-5678-9012', 'id_type' => 'PhilSys'],
                ['full_name' => 'Maria Clara', 'contact_number' => '09189876543', 'email' => 'maria@example.com', 'address' => '456 Mabini St, Baliuag, Bulacan', 'id_number' => 'UMID-987654', 'id_type' => 'UMID'],
                ['full_name' => 'Jose Rizal', 'contact_number' => '09221112233', 'email' => null, 'address' => '789 Bonifacio St, Baliuag, Bulacan', 'id_number' => 'P1234567', 'id_type' => 'Passport'],
            ]);
        }

        if (Contract::count() === 0) {
            Contract::insert([
                ['client_id' => 1, 'plot_id' => 1, 'contract_date' => '2025-01-15', 'total_amount' => 25000, 'payment_type' => 'cash', 'status' => 'completed'],
                ['client_id' => 2, 'plot_id' => 2, 'contract_date' => '2025-03-20', 'total_amount' => 25000, 'payment_type' => 'installment', 'status' => 'active'],
            ]);
        }

        if (Payment::count() === 0) {
            Payment::insert([
                ['contract_id' => 1, 'amount_paid' => 25000, 'payment_type' => 'cash', 'reference_number' => 'OR-001', 'receipt_number' => 'RCP-001', 'paid_at' => '2025-01-15 10:00:00'],
                ['contract_id' => 2, 'amount_paid' => 5000, 'payment_type' => 'installment', 'reference_number' => 'OR-002', 'receipt_number' => 'RCP-002', 'paid_at' => '2025-03-20 14:00:00'],
            ]);
        }

        if (Burial::count() === 0) {
            Burial::insert([
                ['plot_id' => 1, 'contract_id' => 1, 'deceased_name' => 'Maria Santos', 'date_of_birth' => '1935-06-12', 'date_of_death' => '2010-11-20', 'burial_date' => '2010-11-22 09:00:00', 'burial_status' => 'completed', 'scheduled_by' => 1, 'approved_at' => '2010-11-21 10:00:00'],
                ['plot_id' => 2, 'contract_id' => 2, 'deceased_name' => 'Jose Reyes', 'date_of_birth' => '1942-03-05', 'date_of_death' => '2015-08-14', 'burial_date' => '2015-08-16 10:00:00', 'burial_status' => 'completed', 'scheduled_by' => 1, 'approved_at' => '2015-08-15 14:00:00'],
            ]);
        }
    }
}
