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

namespace Elcodi\AdminCartCouponBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\AdminCoreBundle\Controller\Interfaces\EnableableControllerInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

/**
 * Class Controller for CartCoupon
 *
 * @Route(
 *      path = "/cartcoupon",
 * )
 */
class CartCouponController
    extends
    AbstractAdminController
    implements
    EnableableControllerInterface
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request          Request
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_cart_coupon_list",
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
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        Request $request,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Request   $request          Request
     * @param Paginator $paginator        Paginator instance
     * @param integer   $page             Page
     * @param integer   $limit            Limit of items per page
     * @param string    $orderByField     Field to order by
     * @param string    $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_cart_coupon_list_component",
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
     * @Template
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      class = "elcodi.core.cartcoupon.entity.cart_coupon.class",
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
        $paginatorFields = $this
            ->container
            ->getParameter('elcodi.admin.cartcoupon.pagination.cart_coupon.fields');

        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'paginatorFields'  => $paginatorFields,
        ];
    }

    /**
     * View element action.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request Request
     * @param integer $id      Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_cart_coupon_view",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template
     * @Method({"GET"})
     */
    public function viewAction(
        Request $request,
        $id
    )
    {
        return [
            'id' => $id,
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
     *      name = "admin_cart_coupon_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.cartcoupon.factory.cart_coupon",
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
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_cart_coupon_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction()
    {
        return [];
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
     *      name = "admin_cart_coupon_new_component"
     * )
     * @Template
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.cartcoupon.factory.cart_coupon",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_coupon_form_type_cart_coupon",
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
     * Save new element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to save
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_cart_coupon_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.cartcoupon.factory.cart_coupon",
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_coupon_form_type_cart_coupon",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        Request $request,
        AbstractEntity $entity,
        FormInterface $form,
        $isValid
    )
    {
        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_cart_coupon_view", [
            'id'    =>  $entity->getId(),
        ]);
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsability
     *
     * @param Request $request Request
     * @param integer $id      Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_cart_coupon_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction(
        Request $request,
        $id
    )
    {
        return [
            'id' => $id,
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
     *      name = "admin_cart_coupon_edit_component"
     * )
     * @Template
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cart_coupon.entity.cart_coupon.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_coupon_form_type_cart_coupon",
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
            'form' => $formView,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to update
     * @param FormInterface  $form    Form view
     * @param boolean        $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_cart_coupon_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cartcoupon.entity.cart_coupon.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_cart_coupon_form_type_cart_coupon",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        Request $request,
        AbstractEntity $entity,
        FormInterface $form,
        $isValid
    )
    {
        $this
            ->getManagerForClass($entity)
            ->flush($entity);

        return $this->redirectRoute("admin_cart_coupon_view", [
            'id'    =>  $entity->getId(),
        ]);
    }

    /**
     * Enable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/enable",
     *      name = "admin_cart_coupon_enable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cartcoupon.entity.cart_coupon.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function enableAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        try {
            $this->enableEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Disable entity
     *
     * @param Request        $request Request
     * @param AbstractEntity $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/disable",
     *      name = "admin_cart_coupon_disable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cartcoupon.entity.cart_coupon.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function disableAction(
        Request $request,
        AbstractEntity $entity
    )
    {
        try {
            $this->disableEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Updated edited element action
     *
     * @param Request        $request     Request
     * @param AbstractEntity $entity      Entity to delete
     * @param string         $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_cart_coupon_delete"
     * )
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.cartcoupon.entity.cart_coupon.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function deleteAction(
        Request $request,
        AbstractEntity $entity,
        $redirectUrl = null
    )
    {
        try {
            $this->deleteEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }
}
