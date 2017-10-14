<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Color;
use AppBundle\Entity\Product;
use AppBundle\Entity\Size;
use AppBundle\Entity\Status;
use AppBundle\Form\AddToCartType;
use AppBundle\Form\ProductImageType;
use AppBundle\Form\ProductType;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/product/{id}", name="product_view", requirements={"id": "\d+"})
     */
    public function viewProductAction(int $id, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            return $this->redirectToRoute('product_view_all');
        }

        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = new Cart();

            $color = $form->get('color')->getData();
            $size = $form->get('size')->getData();
            $quantity = $form->get('quantity')->getData();

            if (!is_numeric($color) || $color < 1) {
                return $this->render('product/view.html.twig', array(
                    'product' => $product,
                    'form' => $form->createView()
                ));
            }

            if (!is_numeric($size) || $size < 1) {
                return $this->render('product/view.html.twig', array(
                    'product' => $product,
                    'form' => $form->createView()
                ));
            }

            if (!is_numeric($quantity) || $quantity < 1) {
                return $this->render('product/view.html.twig', array(
                    'product' => $product,
                    'form' => $form->createView()
                ));
            }

            $color = $this->getDoctrine()->getRepository(Color::class)
                ->find($form->get('color')->getData());

            $size = $this->getDoctrine()->getRepository(Size::class)
                ->find($form->get('size')->getData());

            $status = $this->getDoctrine()->getRepository(Status::class)
                ->find(1);

            $cart->setProduct($product);
            $cart->setColor($color);
            $cart->setSize($size);
            $cart->setQuantity($quantity);
            $cart->setStatus($status);
            date_default_timezone_set('Europe/Sofia');
            $cart->setPostedOn(new \DateTime('now'));
            $cart->setOwner($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($cart);
            $em->flush();

            return $this->redirectToRoute('cart_view');
        }

        return $this->render('product/view.html.twig', array(
            'product' => $product,
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/", name="product_view_all")
     */
    public function viewAllProducts(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)
            ->findAll();

        /** @var Paginator $paginator */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 12)
        );

        return $this->render('product/viewAll.html.twig', array(
            'products' => $result
        ));
    }

    /**
     * @param int $id
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/brand/{id}", name="product_view_brand", requirements={"id": "\d+"})
     */
    public function viewProductsByBrand(int $id, Request $request)
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)->getProductsbyBrand($id);

        /** @var Paginator $paginator */
        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 12)
        );

        return $this->render('product/viewAll.html.twig', array('products' => $result));
    }

    /**
     * @param Request $request
     *
     * @Route("/admin/product/add", name="admin_product_add")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(Request $request)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Upload picture logic
            $imagePath = 'images/products/';
            $uploadService = $this->get('picture_upload');
            $uploadService->uploadPicture($product, $imagePath);

            $product->setAddedBy($this->getUser());

            $product->setLive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_view', array('id' => $product->getId()));
        }

        $btnValue = "Add";

        return $this->render('product/add.html.twig', array(
            'form' => $form->createView(),
            'buttonValue' => $btnValue
        ));
    }

    /**
     * @param Request $request
     *
     * @param int $id
     *
     * @Route("/admin/product/edit/{id}", name="admin_product_edit", requirements={"id": "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProductAction(Request $request, int $id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setLive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_view', array('id' => $product->getId()));
        }

        $btnValue = "Edit";

        return $this->render('product/add.html.twig', array(
            'form' => $form->createView(),
            'buttonValue' => $btnValue
        ));
    }

    /**
     * @param Request $request
     *
     * @param int $id
     *
     * @Route("/admin/product/image/edit/{id}", name="admin_product_image_edit", requirements={"id": "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editImageAction(int $id, Request $request)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductImageType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagePath = 'images/products/';
            $uploadService = $this->get('picture_upload');
            $uploadService->uploadPicture($product, $imagePath);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_view', array('id' => $product->getId()));
        }

        return $this->render('product/edit_picture.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/products/category/{id}", name="product_view_category", requirements={"id": "\d+"})
     */
    public function viewCategory(Request $request, int $id)
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)->getProductsbyCategory($id);

        /** @var Paginator $paginator */
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 12)
        );

        return $this->render('product/viewAll.html.twig', array(
            'products' => $pagination
        ));
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/product/color/select/{id}", name="admin_product_color_select", requirements={"id": "\d+"})
     */
    public function selectColorAction(int $id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $colors = $this->getDoctrine()->getRepository(Color::class)->findAll();

        return $this->render('product/color_select.html.twig', array(
            'product' => $product,
            'colors' => $colors
        ));
    }

    /**
     * @param $colors
     *
     * @param $product_id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/admin/product/color/set/{colors}/{product_id}", name="admin_product_color_set")
     */
    public function setColorAction($colors, $product_id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($product_id);

        $colors = explode(",", $colors);

        $product->removeColors();

        foreach ($colors as $color_id) {
            $color = $this->getDoctrine()->getRepository(Color::class)->find($color_id);

            if (!in_array($color, $product->getColors())) {
                $product->addColor($color);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->redirectToRoute('product_view', array(
            'id' => $product_id
        ));
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/product/size/select/{id}", name="admin_product_size_select", requirements={"id": "\d+"})
     */
    public function selectSizeAction(int $id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $sizes = $this->getDoctrine()->getRepository(Size::class)->findAll();

        return $this->render('product/size_select.html.twig', array(
            'product' => $product,
            'sizes' => $sizes
        ));
    }

    /**
     * @param $sizes
     *
     * @param $product_id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/admin/product/size/set/{sizes}/{product_id}", name="admin_product_size_set")
     */
    public function setSizeAction($sizes, $product_id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $product = $this->getDoctrine()->getRepository(Product::class)->find($product_id);

        $sizes = explode(",", $sizes);

        $product->removeSizes();

        foreach ($sizes as $size_id) {
            $size = $this->getDoctrine()->getRepository(Size::class)->find($size_id);

            if (!in_array($size, $product->getSizes())) {
                $product->addSize($size);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->redirectToRoute('product_view', array(
            'id' => $product_id
        ));
    }
}
