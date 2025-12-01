<?php

namespace App\Models;

class User
{
    public ?int $id = null;

    // identity
    public string $phone;
    public ?string $email = null;
    public ?string $username = null;

    // password & security
    public string $password_hash;
    public bool $is_password_temporary = true;

    // name
    public string $first_name;
    public string $last_name;

    // roles (multi-role support)
    public array $roles = []; // ['admin','teacher']

    // lifecycle & status
    public string $status = 'pending_verification';
    public bool $phone_verified = false;

    // timestamps
    public ?string $last_login = null;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at = null;

    // audit
    public ?int $created_by = null;
    public ?int $updated_by = null;

    public function __construct(array $data)
    {
        if (isset($data['user_id'])) {
            $data['id'] = $data['user_id'];
        }

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // helpers
    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtolower($role), array_map('strtolower', $this->roles));
    }

    public function hasRoleAny(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) return true;
        }
        return false;
    }
    
    public function isAdmin(): bool { return $this->hasRole('admin'); }
    public function isAuditor(): bool { return $this->hasRole('auditor'); }
    public function isTeacher(): bool { return $this->hasRole('teacher'); }
    public function isParent(): bool { return $this->hasRole('parent'); }
    public function isStudent(): bool { return $this->hasRole('student'); }

    // In App\Models\User.php

    public function sanitizeForFrontend(): array
    {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'roles'         => $this->roles,
            'status'        => $this->status,
            'phone_verified'=> $this->phone_verified,
            'last_login'    => $this->last_login,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at
        ];
    }
}
