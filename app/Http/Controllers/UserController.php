<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PP\Interface\UserRepository;
use App\Repositories\User\UserInterface as UserInterface;


class UserController extends Controller
{
    private UserInterface $UserRepository;


    public function __construct(UserInterface $UserRepository)
    {
        $this->userrepository = $UserRepository;
    }
    public function index()
    {
        $users = $this->userrepository->getall();
        return response()->json();
    }
    public function show($id)
    {
        $user = $this->userrepository->find($id);
        return response()->json();
    }
    public function delete($id)
    {
        $this->userrepository->delete($id);
        return response()->json([
            'message'=>'user '.$id.' has been deleted successfully'
        ]);
    }
}
