<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('',['filter' => 'login'], function($routes){
    $routes->match(['get','post'],'/', 'Home::index');

    $routes->match(['get','post'],'users/', 'Auth\Users::index', ['as' => 'users']);
    $routes->match(['get','post'],'users/getAll', 'Auth\Users::getAll');
    $routes->match(['get','post'],'users/getOne', 'Auth\Users::getOne');
    $routes->match(['get','post'],'users/edit', 'Auth\Users::edit');
    $routes->match(['get','post'],'users/getRoles', 'Auth\Users::getRoles');
    $routes->match(['get','post'],'users/setRoles', 'Auth\Users::setRoles');

    $routes->match(['get','post'],'roles/', 'Auth\Roles::index', ['as' => 'roles']);
    $routes->match(['get','post'],'roles/getAll', 'Auth\Roles::getAll');
    $routes->match(['get','post'],'roles/getRoles', 'Auth\Roles::getRoles');
    $routes->match(['get','post'],'roles/getPermisos', 'Auth\Roles::getPermisos');
    $routes->match(['get','post'],'roles/setPermisos', 'Auth\Roles::setPermisos');
    $routes->match(['get','post'],'roles/permissionsRemove', 'Auth\Roles::permissionsRemove');
    $routes->match(['get','post'],'roles/ajax_add', 'Auth\Roles::ajax_add');
    $routes->match(['get','post'],'roles/ajax_edit', 'Auth\Roles::ajax_edit');
    $routes->match(['get','post'],'roles/ajax_update', 'Auth\Roles::ajax_update');
    $routes->match(['get','post'],'roles/ajax_delete', 'Auth\Roles::ajax_delete');

    $routes->match(['get','post'],'permissions/', 'Auth\Permissions::index', ['as' => 'permissions']);
    $routes->match(['get','post'],'permissions/getAll', 'Auth\Permissions::getAll');
    $routes->match(['get','post'],'permissions/ajax_add', 'Auth\Permissions::ajax_add');
    $routes->match(['get','post'],'permissions/ajax_edit', 'Auth\Permissions::ajax_edit');
    $routes->match(['get','post'],'permissions/ajax_update', 'Auth\Permissions::ajax_update');
    $routes->match(['get','post'],'permissions/ajax_delete', 'Auth\Permissions::ajax_delete');
    $routes->match(['get','post'],'permissions/getPermisos', 'Auth\Permissions::getPermisos');

});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
