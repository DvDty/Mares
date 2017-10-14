<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\EventSubscriber\LocaleSubscriber;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)->getRecent4();

        return $this->render("index.html.twig", array(
            'articles' => $articles
        ));
    }

    /**
     * @param Request $request
     *
     * @param $language
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/changelang/{language}", name="change_language")
     */
    public function changeLanguageAction(Request $request, $language)
    {
        if ($language != "bg" && $language != "en") {
            return $this->redirectToRoute('index');
        }

        $request->setLocale($language);
        $request->getSession()->set('_locale', $language);

        return $this->redirectToRoute("index");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/terms-conditions", name="terms")
     */
    public function showTermsAction()
    {
        return $this->render('footer/terms.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/contact-us", name="contact")
     */
    public function contactUsAction()
    {
        return $this->render('footer/contactUs.html.twig');
    }
}
