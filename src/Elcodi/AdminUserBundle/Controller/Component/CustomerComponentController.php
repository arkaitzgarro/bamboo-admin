<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\AdminUserBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

/**
 * Class CustomerComponentsController
 *
 * @Route(
 *      path = "/user/customer",
 * )
 */
class CustomerComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request             $request             Request
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_customer_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminUserBundle:Customer:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.user.entity.customer.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listComponentAction(
        Request $request,
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * Component for entity view
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/component/{id}",
     *      name = "admin_customer_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminUserBundle:Customer:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.user.factory.customer",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewComponentAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * New element action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request  $request  Request
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     *      name = "admin_customer_new_component"
     * )
     * @Template("AdminUserBundle:Customer:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.user.factory.customer",
     *      }
     * )
     * @FormAnnotation(
     *      class = "admin_user_form_type_customer",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(
        Request $request,
        FormView $formView
    )
    {
        return [
            'form' => $formView,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request        $request  Request
     * @param AbstractEntity $entity   Entity
     * @param FormView       $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_customer_edit_component"
     * )
     * @Template("AdminUserBundle:Customer:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.user.entity.customer.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "admin_user_form_type_customer",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        Request $request,
        AbstractEntity $entity,
        FormView $formView
    )
    {
        return [
            'entity' => $entity,
            'form'   => $formView,
        ];
    }
}
