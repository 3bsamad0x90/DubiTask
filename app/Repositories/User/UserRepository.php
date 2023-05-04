<?php

namespace App\Repositories\User;

interface UserRepository {
    public function store($request, $user_type);
}
?>
