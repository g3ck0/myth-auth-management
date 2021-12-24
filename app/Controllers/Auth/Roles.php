<?php

namespace App\Controllers\Auth;
use App\Controllers\BaseController;

class Roles extends BaseController
{
    protected $validation;
    protected $authorize;

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->authorize = service('authorization');
    }

    public function index()
    {
        $data = [
            'controller'    	=> 'roles',
            'title'     		=> 'Roles'
        ];

        return view('management/roles/view', $data);
    }

    public function getAll()
    {
        if ($this->request->isAJAX())
        {
            $data['data'] = array();
            $result = $this->authorize->groups();

            foreach ($result as $key => $value) {

                $ops = '<div class="btn-group">';
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit_item('. $value->id .')"><i class="fa fa-edit"></i></button>';
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->id .')"><i class="fa fa-trash"></i></button>';
                $ops .= '	<button type="button" class="btn btn-sm btn-primary" onclick="show_permissions('. $value->id .')"><i class="fa fa-tags"></i></button>';
                $ops .= '</div>';

                $data['data'][$key] = array(
                    $value->name,
                    $value->description,
                    $ops,
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function getRoles()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $roles = $this->authorize->groups();
            if(isset($roles))
            {
                $items = array();
                foreach($roles as $key => $value)
                {
                    $items[] = $value->name;
                }
                $data = array('status' => true,
                    'items' => $items
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function getPermisos(){
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $id = $this->request->getPostGet('RoleId');
            $permisos = $this->authorize->groupPermissions($id);
            if(isset($permisos))
            {
                $items = array();
                foreach($permisos as $key => $value)
                {
                    $items[] = $value['name'];
                }
                $data = array('status' => true,
                    'items' => $items
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function ajax_add()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $name = $this->request->getGetPost('name');
            $description = $this->request->getGetPost('description');
            if($this->authorize->createGroup($name, $description))
            {
                $data = array('status' => true);
            }
            else
            {
                $data = array('status' => false, 'errores' => $this->authorize->error(), 'message' => lang('Mythauth.role_error_validation'));
            }
            return $this->response->setJSON($data);
        }
    }

    public function ajax_edit()
    {
        if ($this->request->isAJAX())
        {
            $id = $this->request->getPost('RolId');
            $group = $this->authorize->group($id);
            $data = array('status' => true,
                'item' => $group
            );
            return $this->response->setJSON($data);
        }
    }

    public function ajax_update()
    {
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $id = $this->request->getGetPost('id');
            $name = $this->request->getGetPost('name');
            $description = $this->request->getGetPost('description');
            if($this->authorize->updateGroup($id, $name, $description))
            {
                $data = array('status' => true);
            }
            else
            {
                $data = array('status' => false, 'errores' => $this->authorize->error(), 'message' => lang('Mythauth.role_error_validation_update'));
            }
            return $this->response->setJSON($data);
        }
    }

    public function ajax_delete()
    {
        if ($this->request->isAJAX())
        {
            $id = $this->request->getPost('RolId');
            $group = $this->authorize->deleteGroup($id);
            $data = array('status' => true);
            return $this->response->setJSON($data);
        }
    }

    public function setPermisos(){
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $id = $this->request->getPostGet('RoleId');
            $Newpermisos = $this->request->getPostGet('Permisos');
            $permisos = $this->authorize->groupPermissions($id);
            if(isset($Newpermisos))
            {
                if(isset($permisos))
                {
                    $items = array();
                    foreach($permisos as $key => $value)
                    {
                        $this->authorize->removePermissionFromGroup($value['name'], $id);
                    }
                }
                foreach($Newpermisos as $key => $value)
                {
                    $this->authorize->addPermissionToGroup($value, $id);
                }
                $data = array('status' => true,
                    'message' => lang('Mythauth.role_permissions_assigned')
                );
            }
            return $this->response->setJSON($data);
        }
    }

    public function permissionsRemove(){
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $id = $this->request->getPostGet('RoleId');
            if(isset($permisos))
            {
                $items = array();
                foreach($permisos as $key => $value)
                {
                    $this->authorize->removePermissionFromGroup($value, $id);
                }
            }
            $data = array('status' => true,
                'message' => lang('Mythauth.role_permissions_removed')
            );
            return $this->response->setJSON($data);
        }
    }
}