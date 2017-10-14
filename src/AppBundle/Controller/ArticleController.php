<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("admin/article/add", name="admin_article_add")
     */
    public function addArticleAction(Request $request)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute("index");
        }

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setPostedBy($this->getUser());
            $article->setPostedOn(new \DateTime('now'));

            // Upload picture logic
            $imagePath = 'images/articles/';
            $uploadService = $this->get('picture_upload');

            //$uploadService->uploadPicture($article, null, $imagePath);
            $uploadService->uploadPicture($article, $imagePath);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_view', array('id' => $article->getId()));
        }

        $btnValue = "Add";

        return $this->render('article/add.html.twig', array(
            'form' => $form->createView(),
            'buttonValue' => $btnValue
        ));
    }

    /**
     * @param Request $request
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("admin/article/edit/{id}", name="admin_article_edit", requirements={"id": "\d+"})
     */
    public function editArticleAction(Request $request, int $id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute("index");
        }

        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload picture logic
            $oldPicture = $article->getImage();
            $imagePath = 'images/articles/';
            $uploadService = $this->get('picture_upload');
            $uploadService->uploadPicture($article, $imagePath, $oldPicture);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_view', array('id' => $article->getId()));
        }

        $btnValue = "Edit";

        return $this->render('article/add.html.twig', array(
            'form' => $form->createView(),
            'buttonValue' => $btnValue
        ));
    }


    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/article/{id}", name="article_view", requirements={"id": "\d+"})
     */
    public function viewArticleAction(int $id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id);

        $article->setViews($article->getViews() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id);

        return $this->render('article/view.html.twig', array(
            'article' => $article
        ));
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("admin/article/delete/{id}", name="admin_article_delete", requirements={"id": "\d+"})
     */
    public function deleteArticleAction($id)
    {
        if (!$this->getUser()->isAdmin()) {
            return $this->redirectToRoute("index");
        }

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
