<?php

namespace App\Services;

use App\Repositories\ChatbotRepository;
use App\Repositories\ActivityLogRepository;

class ChatbotAdminService
{
    private ChatbotRepository $repo;
    private ActivityLogRepository $activityLog;

    public function __construct()
    {
        $this->repo = new ChatbotRepository();
        $this->activityLog = new ActivityLogRepository;
    }

    public function getAll(): array
    {
        return array_map(fn($c) => $c->sanitizeForFrontend(), $this->repo->getAll());
    }

    public function create(array $data): array
    {
        if (empty($data['question']) || empty($data['answer'])) {
            return ['type' => 'error', 'message' => 'Fill in all fields'];
        }

        $this->repo->insert($data['question'], $data['answer']);
        $this->activityLog->log($_SESSION['user_id'], "Added Question", "Question \"{$data['question']}\" added");

        return ['type' => 'success', 'message' => 'FAQ added successfully'];
    }

    public function update(array $data): array
    {
        if (empty($data['question']) || empty($data['answer'])) {
            return ['type' => 'error', 'message' => 'Fill in all fields'];
        }

        $this->repo->update($data['id'], $data['question'], $data['answer']);
        $this->activityLog->log($_SESSION['user_id'], "Updated Question", "Question \"{$data['question']}\" updated");

        return ['type' => 'success', 'message' => 'FAQ updated successfully'];
    }

    public function delete(int $id): array
    {
        $this->repo->delete($id);
        $this->activityLog->log($_SESSION['user_id'], "Deleted Question", "ID: {$id}");

        return ['type' => 'success', 'message' => 'FAQ deleted'];
    }
}
