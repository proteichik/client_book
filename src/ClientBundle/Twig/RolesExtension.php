<?php

namespace ClientBundle\Twig;

class RolesExtension extends \Twig_Extension
{
    protected $mapping = array(
        'ROLE_USER' => 'Менеджер',
        'ROLE_ADMIN' => 'Начальник отдела',
        'ROLE_SUPER_ADMIN' => 'Администратор',
    );

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('roles', array($this, 'rolesFilter'))
        );
    }

    public function rolesFilter($role)
    {
        return (isset($this->mapping[$role])) ? $this->mapping[$role] : $role;
    }


    public function getName()
    {
        return 'roles';
    }

}