<?php

namespace Modules\Marketing\Services;

use \Modules\Marketing\Repositories\NewsLetterRepository;

class NewsLetterService{
    
    protected $newsLetterRepository;

    public function __construct(NewsLetterRepository $newsLetterRepository)
    {
        $this->newsLetterRepository = $newsLetterRepository;
    }

    public function getAll(){
        return $this->newsLetterRepository->getAll();
    }

    public function store($data){
        return $this->newsLetterRepository->store($data);
    }
    public function update($data){
        return $this->newsLetterRepository->update($data);
    }
    public function getAllRole(){
        return $this->newsLetterRepository->getAllRole();
    }
    public function getAllUser(){
        return $this->newsLetterRepository->getAllUser();
    }
    public function getAllSubscriber(){
        return $this->newsLetterRepository->getAllSubscriber();
    }
    public function getEmailTemplate(){
        return $this->newsLetterRepository->getEmailTemplate();
    }
    public function getUserByRole($id){
        return $this->newsLetterRepository->getUserByRole($id);
    }
    public function editById($id){
        return $this->newsLetterRepository->editById($id);
    }
    public function deleteById($id){
        return $this->newsLetterRepository->deleteById($id);
    }

    public function testMail($data){
        return $this->newsLetterRepository->testMail($data);
    }
}
