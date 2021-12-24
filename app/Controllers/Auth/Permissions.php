<?php

namespace App\Controllers\Auth;
use App\Controllers\BaseController;

class Permissions extends BaseController
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
            'controller'    	=> 'permissions',
            'title'     		=> 'Permissions'
        ];

        return view('management/permissions/view', $data);
    }

    public function getAll()
    {
        if ($this->request->isAJAX())
        {
            $data['data'] = array();
            $result = $this->authorize->permissions();

            foreach ($result as $key => $value) {
                $ops = '<div class="btn-group">';
                $ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit_item('. $value['id'] .')"><i class="fa fa-edit"></i></button>';
                $ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value['id'] .')"><i class="fa fa-trash"></i></button>';
                $ops .= '</div>';

                $data['data'][$key] = array(
                    $value['name'],
                    $value['description'],
                    $ops,
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
            if($this->authorize->createPermission($name, $description))
            {
                $data = array('status' => true);
            }
            else
            {
                $data = array('status' => false, 'errores' => $this->authorize->error(), 'message' => lang('Mythauth.permission_error_validation'));
            }
            return $this->response->setJSON($data);
        }
    }

    public function ajax_edit()
    {
        if ($this->request->isAJAX())
        {
            $id = $this->request->getPost('PermissionId');
            $group = $this->authorize->permission($id);
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
            if($this->authorize->updatePermission($id, $name, $description))
            {
                $data = array('status' => true);
            }
            else
            {
                $data = array('status' => false, 'errores' => $this->authorize->error(), 'message' => lang('Mythauth.permission_error_validation_update'));
            }
            return $this->response->setJSON($data);
        }
    }

    public function ajax_delete()
    {
        if ($this->request->isAJAX())
        {
            $id = $this->request->getPost('PermissionId');
            $group = $this->authorize->deletePermission($id);
            $data = array('status' => true);
            return $this->response->setJSON($data);
        }
    }

    public function getPermisos(){
        if ($this->request->isAJAX())
        {
            $data = array('status' => false);
            $permisos = $this->authorize->permissions();
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

}