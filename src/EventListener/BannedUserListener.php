<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class BannedUserListener
{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;

    public function __construct(
        Security $security,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig
    ) {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        $ignoredRoutes = [
            'app_login',
            'app_logout',
            'app_register',
            '_wdt',
            '_profiler',
            '_twig_error_test',
            'app_banned_notice'
        ];

        if (in_array($route, $ignoredRoutes) || str_starts_with($route, '_')) {
            return;
        }

        $user = $this->security->getUser();
        
        if ($user && in_array('ROLE_BANNED', $user->getRoles())) {
            $response = new Response(
                $this->twig->render('security/banned.html.twig', [
                    'user' => $user,
                    'route' => $route
                ]),
                Response::HTTP_FORBIDDEN
            );
            
            $event->setResponse($response);
        }
    }
}
