<?php

namespace App\Service;

use App\Entity\HowWorks;
use App\Entity\Step;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HowWorksService
{
    private EntityManagerInterface $entityManager;
    private IconUploadService $iconUploadService;

    public function __construct(EntityManagerInterface $entityManager, IconUploadService $iconUploadService)
    {
        $this->entityManager = $entityManager;
        $this->iconUploadService = $iconUploadService;
    }

    public function saveHowWorksWithSteps(HowWorks $howWorks, array $uploadedFiles = []): void
    {
        try {
            // Traiter les uploads d'icônes pour chaque step
            $stepIndex = 0;
            foreach ($howWorks->getSteps() as $step) {
                // S'assurer que la relation est correctement définie
                $step->setHowWork($howWorks);
                
                // Traiter l'upload d'icône si présent
                if (isset($uploadedFiles[$stepIndex]) && $uploadedFiles[$stepIndex] instanceof UploadedFile) {
                    $filename = $this->iconUploadService->upload($uploadedFiles[$stepIndex]);
                    $step->setIcon($filename);
                }
                
                $stepIndex++;
            }

            // Persister l'entité HowWorks (les Steps seront persistées automatiquement grâce à cascade)
            $this->entityManager->persist($howWorks);
            $this->entityManager->flush();
            
        } catch (\Exception $e) {
            // En cas d'erreur, essayer de récupérer un nouvel EntityManager
            if (!$this->entityManager->isOpen()) {
                $this->entityManager = $this->entityManager->create(
                    $this->entityManager->getConnection(),
                    $this->entityManager->getConfiguration()
                );
            }
            
            throw $e;
        }
    }
}
