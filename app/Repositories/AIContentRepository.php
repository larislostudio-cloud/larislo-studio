<?php

namespace App\Repositories;

use App\Models\AIContent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AIContentRepository
{
    protected $model;

    public function __construct(AIContent $model)
    {
        $this->model = $model;
    }

    /**
     * Simpan hasil generate AI ke database.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Ambil riwayat konten user dengan paginasi.
     */
    public function getUserHistory($userId, $type = null, $perPage = 10)
    {
        $query = $this->model->where('user_id', $userId)->latest();

        if ($type) {
            $query->where('type', $type);
        }

        return $query->paginate($perPage);
    }

    /**
     * Hitung total penggunaan AI oleh user di bulan ini.
     * Berguna untuk validasi limit kredit.
     */
    public function getMonthlyUsageCount($userId)
    {
        return $this->model->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    /**
     * Cari konten berdasarkan ID.
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Hapus konten.
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
