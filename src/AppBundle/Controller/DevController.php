<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/admin/cache-clear-prod")
     */
    public function refreshRoutes()
    {
        if ($this->getUser()->getEmail() != "pavel@abv.bg") {
            return new Response(
                '<h1>403 Access denied!</h1>'
            );
        }

        $kernel = $this->container->get('kernel');

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'cache:clear',
            '--env'   => 'prod',
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        return new Response(
            'Cache -prod cleared!'
        );
    }
}
