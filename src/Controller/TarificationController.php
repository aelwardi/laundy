<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TarificationController extends AbstractController
{
    #[Route('/tarif', name: 'app_tarification')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->tarifServices();
        return $this->render('tarification/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/tarif/details/{id}', name: 'app_tarif_details')]
    public function detail(ServiceRepository $serviceRepository, int $id): Response
    {
        $service = $serviceRepository->find($id);
        $services = $serviceRepository->tarifServices();
        return $this->render('tarification/detailService.html.twig', [
            'service' => $service,
            'services' => $services,
        ]);
    }
}
