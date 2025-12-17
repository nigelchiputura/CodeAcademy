<?php

namespace App\Services;

class UploadService
{
    /**
     * Upload a service image and return the relative path.
     *
     * @param array $file The $_FILES['image'] array
     * @param string $folder Folder inside /public/uploads/
     * @return string|null Relative path (e.g. "services/abc123.jpg") or null if no file uploaded.
     */
    public static function uploadImage(array $file, string $folder = 'services'): ?string
    {
        // If no file uploaded
        if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        // Validate error codes
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Image upload failed with error code: " . $file['error']);
        }

        // Validate MIME type
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowed)) {
            throw new \Exception("Invalid image type. Only JPG, PNG, or WEBP allowed.");
        }

        // Extract extension
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Generate unique name
        $filename = uniqid('svc_', true) . '.' . $extension;

        // Define upload directory
        $uploadDir = __DIR__ . '/../../public/uploads/' . $folder;

        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        // Final full path
        $destination = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception("Failed to save uploaded image.");
        }

        // Return relative path for DB
        return $folder . '/' . $filename;
    }
}