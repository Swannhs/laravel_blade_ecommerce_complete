<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function store(array $data);

    public function find($id);

    public function findUser($id);

    public function findDocument($id);

    public function update(array $data, $id);

    public function updateProfile(array $data, $id);

    public function statusUpdate(array $data);

    public function delete($id);

    public function deleteStaffDoc($id);

    public function user();
    
    public function normalUser();

    public function staffImgDelete($id);
}
