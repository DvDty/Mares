<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Color;
use AppBundle\Form\ColorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class ColorController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     *
     * @Route("/admin/color/add", name="admin_color_add")
     */
    public function addColor(Request $request)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute('index');
        }

        $color = new Color();

        $form = $this->createForm(ColorType::class, $color);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getDoctrine()
                    ->getRepository(Color::class)
                    ->findBy(array('name' => $form->get("Name")
                    ->getData()))) {
                throw new \Exception("Color with this name already exist");
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($color);

            $em->flush();

            return $this->redirectToRoute('product_view_all');
        }

        return $this->render('color/add.html.twig', array('form' => $form->createView()));
    }
}
