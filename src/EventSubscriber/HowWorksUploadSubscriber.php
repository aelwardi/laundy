<?php

namespace App\EventSubscriber;

use App\Entity\HowWorks;
use App\Entity\Step;
use App\Service\IconUploadService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class HowWorksUploadSubscriber implements EventSubscriberInterface
{
    private IconUploadService $iconUploadService;
    private RequestStack $requestStack;

    public function __construct(IconUploadService $iconUploadService, RequestStack $requestStack)
    {
        $this->iconUploadService = $iconUploadService;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['uploadStepIcons'],
            BeforeEntityUpdatedEvent::class => ['uploadStepIcons'],
        ];
    }

    public function uploadStepIcons(BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof HowWorks) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return;
        }

        $files = $request->files->all();
        
        if (isset($files['HowWorks']['steps'])) {
            $stepIndex = 0;
            foreach ($entity->getSteps() as $step) {
                if (isset($files['HowWorks']['steps'][$stepIndex]['iconFile'])) {
                    $uploadedFile = $files['HowWorks']['steps'][$stepIndex]['iconFile'];
                    
                    if ($uploadedFile instanceof UploadedFile && $uploadedFile->isValid()) {
                        $filename = $this->iconUploadService->upload($uploadedFile);
                        $step->setIcon($filename);
                    }
                }
                $stepIndex++;
            }
        }
    }
}
