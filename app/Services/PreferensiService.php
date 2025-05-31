<?php

namespace App\Services;

class PreferensiService
{
    public function getKategoriLokasi($provPerusahaan, $kotaPerusahaan)
    {
        if ('35' == $provPerusahaan) {
            return '3573' == $kotaPerusahaan ? 'dalam_kota' : 'luar_kota';
        }
        return 'luar_provinsi';
    }

    public function getSkorPreferensi($kategori, $preferensi)
    {
        $index = array_search($kategori, $preferensi);
        return $index !== false ? 3 - $index : 0;
    }
}
