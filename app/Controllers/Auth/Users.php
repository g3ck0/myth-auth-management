<?php

namespace App\Controllers\Auth;
use App\Controllers\BaseController;

class Users extends BaseController
{
    protected $validation;

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'controller'    	=> 'users',
            'title'     		=> 'Users',
        ];

        return view('management/users/view', $data);
    }

    public function getAll()
    {
        if ($this->request->isAJAX())
        {
            $data['data'] = array();
            $users = new \Myth\Auth\Models\UserModel();
            $result = $users->findAll();

            foreach ($result as $key => $value) {

                $ops = '<div class="btn-group">';
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->id .')"><i class="fas fa-user-edit"></i></button>';
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="roles('. $value->id .')"><i class="fas fa-users-cog"></i></button>';
                $ops .= '</div>';

                $data['data'][$key] = array(
                    $value->username,
                    $value->email,
                    $ops,
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function getOne()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $users = new \Myth\Auth\Models\UserModel();
            $result = $users->find($this->request->getGetPost('id'));
            if(isset($result))
            {
                $data = array('status' => true,
                    'isActivated' => $result->isActivated(),
                    'isBanned' => $result->isBanned(),
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $users = new \Myth\Auth\Models\UserModel();
            $user = $users->find($this->request->getGetPost('id'));
            if(isset($user))
            {
                if($this->request->getGetPost('Ban'))
                {
                    $user->ban($this->request->getGetPost('reason'));
                }
                else
                {
                    $user->unBan();
                }

                if($this->request->getGetPost('activate'))
                {
                    $user->activate();
                }
                else
                {
                    $user->deactivate();
                }

                if($this->request->getGetPost('forcepassword'))
                {
                    $user->forcePasswordReset();
                }
                if($users->save($user))
                {
                    $data = array('status' => true);
                }
                else
                {
                    $data = array('status' => false,
                        'errors' => $users->errors(),
                        'message' => lang('Mythauth.user_error_update')
                    );
                }
            }
            return $this->response->setJSON($data);
        }
    }

    public function getRoles()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $users = new \Myth\Auth\Models\UserModel();
            $user = $users->find($this->request->getGetPost('id'));
            if(isset($user))
            {
                $results = $user->getRoles();
                $items = array();
                foreach($results as $key => $value)
                {
                    $items[] = $value;
                }
                $data = array('status' => true,
                    'items' => $items
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function setRoles()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $UserId = $this->request->getGetPost('UserId');
            $roles = $this->request->getGetPost('roles');
            $users = new \Myth\Auth\Models\UserModel();
            $user = $users->find($UserId);
            if(isset($user))
            {
                $this->authorize = service('authorization');
                $results = $user->getRoles();
                foreach($results as $key => $value)
                {
                    $this->authorize->removeUserFromGroup($UserId, $value);
                }

                foreach($roles as $key => $value)
                {
                    $items[] = $value;
                    $this->authorize->addUserToGroup($UserId, $value);
                }

                $data = array('status' => true, 'messages' => lang('Mythauth.user_roles_assigned'),
                    'items' => $items
                );
            }
            return $this->response->setJSON($data);
        }
    }
}