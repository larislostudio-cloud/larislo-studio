<?php

namespace App\Repositories;

use App\Models\ScheduledPost;
use Illuminate\Support\Collection;

class PostRepository
{
    protected $model;

    public function __construct(ScheduledPost $model)
    {
        $this->model = $model;
    }

    /**
     * Buat jadwal post baru.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Ambil post yang sudah waktunya dipublikasikan.
     * Digunakan oleh Command/Job scheduler.
     */
    public function getDuePosts()
    {
        return $this->model->where('status', 'scheduled')
            ->where('publish_at', '<=', now())
            ->get();
    }

    /**
     * Update status post (misal setelah publish).
     */
    public function updateStatus($postId, $status, $notes = null)
    {
        $post = $this->model->find($postId);
        if ($post) {
            $post->update([
                'status' => $status,
                'notes' => $notes
            ]);
        }
        return $post;
    }

    /**
     * Ambil jadwal user dengan filter.
     */
    public function getUserPosts($userId, $status = null)
    {
        $query = $this->model->where('user_id', $userId)->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Hitung total post per platform untuk user.
     */
    public function countByPlatform($userId)
    {
        return $this->model->where('user_id', $userId)
            ->select('platform', DB::raw('count(*) as total'))
            ->groupBy('platform')
            ->pluck('total', 'platform');
    }
}
