<?php

namespace App\Models;

class User 
{
    public ?int $id;
    public string $username;
    public string $phone;
    public string $full_name;
    public string $role;
    public ?string $email;
    public ?string $password;
    public ?string $last_login;

    public function __construct(array $data)
    {
        if (isset($data['user_id'])) {
            $data['id'] = $data['user_id'];
        }

        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
