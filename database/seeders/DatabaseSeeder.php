<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret'),
            'is_admin' => true,
        ]);

        Item::create([
            'sku' => '951-AP-BCK-L',
            'nama' => 'Zara Abaya Dubai Turkey By Zulfahcollection 951 AP',
            'jenis' => 'Abaya',
            'warna' => 'Black',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => '951-AP-BCK-S',
            'nama' => 'Zara Abaya Dubai Turkey By Zulfahcollection 951 AP',
            'jenis' => 'Abaya',
            'warna' => 'Black',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => '951-AP-BCK-M',
            'nama' => 'Zara Abaya Dubai Turkey By Zulfahcollection 951 AP',
            'jenis' => 'Abaya',
            'warna' => 'Black',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => '951-AP-BCK-XL',
            'nama' => 'Zara Abaya Dubai Turkey By Zulfahcollection 951 AP',
            'jenis' => 'Abaya',
            'warna' => 'Black',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-NDU-M',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Nude',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-NDU-L',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Nude',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-NDU-S',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Nude',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-NDU-XL',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Nude',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-CKS-S',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Coksu',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-CKS-M',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Coksu',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-CKS-L',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Coksu',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-CKS-XL',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Coksu',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-BCK-S',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Black',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-BCK-M',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Black',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-BCK-L',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Black',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'ZLW-AM-BCK-XL',
            'nama' => 'Oneset Abaya Plus Inner Zilwa Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Black',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-PHJ-S',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Tosca',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-PHJ-M',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Tosca',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-PHJ-L',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Tosca',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-PHJ-XL',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Tosca',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-BMW-S',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Hitam',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-BMW-M',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Hitam',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-BMW-L',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Hitam',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'RAS-AM-BMW-XL',
            'nama' => 'Dress Raya Armani Silk By Zulfahcollection AM',
            'jenis' => 'Dress',
            'warna' => 'Putih Hitam',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-MRA-XL',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Maroon',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-MRA-L',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Maroon',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-MRA-M',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Maroon',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-MRA-S',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Maroon',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-TSC-S',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Toska',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-TSC-M',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Toska',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-TSC-L',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Toska',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-TSC-XL',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Toska',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-OBT-S',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Orange Bata',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-OBT-M',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Orange Bata',
            'ukuran' => 'M',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-OBT-L',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Orange Bata',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => 'CSA-AM-OBT-XL',
            'nama' => 'Oneset Crandeza Silk Dubai Turkey By Zulfahcollection AM',
            'jenis' => 'Oneset',
            'warna' => 'Orange Bata',
            'ukuran' => 'XL',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => '975-AP-CKS-S',
            'nama' => 'Jenah Abaya Dress Turkey By Zulfahcollection AP',
            'jenis' => 'Dress',
            'warna' => 'Coksu',
            'ukuran' => 'S',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
        Item::create([
            'sku' => '857-AP-BCK-L',
            'nama' => 'Abaya Haura Jetblack Dubai Turkey By Zulfahcollection AP',
            'jenis' => 'Abaya',
            'warna' => 'Black',
            'ukuran' => 'L',
            'stok' => '10',
            'material' => '0',
            'archive' => '0',
        ]);
    }
}
