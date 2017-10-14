<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Product;
use AppBundle\Entity\Status;
use AppBundle\Form\StatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/cart", name="cart_view")
     */
    public function viewCart()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $carts = $this->getDoctrine()->getRepository(Cart::class)
            ->findBy(array('owner' => $this->getUser()));

        return $this->render('cart/view.html.twig', array('carts' => $carts));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/purchases", name="admin_purchases_view")
     */
    public function viewPurchases()
    {
        if (!$this->getUser() or !$this->getUser()->isAdmin()) {
            return $this->redirectToRoute("index");
        }

        $carts = $this->getDoctrine()->getRepository(Cart::class)
            ->findAll();

        return $this->render('purchases/viewAll.html.twig', array('carts' => $carts));
    }

    /**
     * @param int $id
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/purchase/{id}", name="admin_purchase_view", requirements={"id": "\d+"})
     */
    public function viewPurchase(int $id, Request $request)
    {
        if (!$this->getUser() or !$this->getUser()->isAdmin()) {
            return $this->redirectToRoute("index");
        }

        $cart = $this->getDoctrine()->getRepository(Cart::class)
            ->find($id);

        //$status = $this->getDoctrine()->getRepository(Status::class)
           // ->find($cart->getStatus()->getId());

        $form = $this->createForm(StatusType::class, $cart);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart);
            $em->flush();

            return $this->redirectToRoute('admin_purchase_view', array('id' => $cart->getId()));
        }

        return $this->render('purchases/view.html.twig', array(
            'cart' => $cart,
            'form' => $form->createView()
        ));
    }
}
