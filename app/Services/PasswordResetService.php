<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\PasswordResetRepository;
use App\Services\TwilioService;

class PasswordResetService
{
    private UserRepository $users;
    private PasswordResetRepository $resets;

    public function __construct()
    {
        $this->users  = new UserRepository();
        $this->resets = new PasswordResetRepository();
        require_once __DIR__ . '/../../functions.php';
    }

    public function requestReset(string $phone): array
    {
        $phone = trim($phone);

        if (empty($phone)) {
            return ['type' => 'error', 'message' => 'Please provide a phone number'];
        }

        $user = $this->users->findByPhone($phone);

        if (!$user) {
            return [
                'type'    => 'success',
                'message' => 'If an account exists for this phone, a reset code has been sent.'
            ];
        }

        $code = (string) random_int(100000, 999999);

        $this->resets->createReset($user->id, $code, 15); // 15-minute expiry

        $subject = "Garage And Gate Experts Password Reset!";

        $html = "
            <p>Your Garage & Gate Experts password reset code is: {$code}. It expires in 15 minutes.</p>
            <p>Click the link below and enter the code you just received:</p>
            <a href='https://garagegurus/password-reset'>Reset Password</a>
        ";

        $emailSent = true;

        try {
            $emailService = new \App\Services\SmtpService();
            $emailService->sendHtml($user->email, $subject, $html);

        } catch (\Throwable $e) {
            $emailSent = false;
        }

        if ($emailSent) {
            return [
                'type'    => 'success',
                'message' => 'If an account exists, a reset code has been sent via Email.'
            ];
        }

        return [
            'type'    => 'error',
            'message' => 'Could not send reset code. Please try again later.'
        ];
    }

    public function resetPassword(string $phone, string $code, string $password, string $confirm): array
    {
        if (inputEmpty($phone, $code, $password, $confirm)) {
            return ['type' => 'error', 'message' => 'Fill in all fields'];
        }

        if ($password !== $confirm) {
            return ['type' => 'error', 'message' => 'Passwords do not match'];
        }

        $user = $this->users->findByPhone(trim($phone));
        if (!$user) {
            return ['type' => 'error', 'message' => 'Invalid phone or code'];
        }

        $resetRow = $this->resets->findValidReset($user->id, trim($code));
        if (!$resetRow) {
            return ['type' => 'error', 'message' => 'Invalid or expired reset code'];
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $ok   = $this->users->updatePassword($user->id, $hash);

        if (!$ok) {
            return ['type' => 'error', 'message' => 'Failed to update password'];
        }

        // mark reset as used
        $this->resets->markUsed((int)$resetRow['reset_id']);

        return ['type' => 'success', 'message' => 'Password reset successfully. You can now log in.'];
    }
}
