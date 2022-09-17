<?php

namespace App\EventSubscriber;

use App\Entity\Activite;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security, private ActiviteRepository $activiteRepository, private EntityManagerInterface $manager)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityPersistedEvent::class => ['createActiviteEvent'],
            AfterEntityUpdatedEvent::class => ['updateActiviteEvent'],
            AfterEntityDeletedEvent::class => ['deleteActiviteEvent'],
        ];
    }

    public function createActiviteEvent(AfterEntityPersistedEvent $event)
    {
        $this->setActivityParentPeriod($event);
    }

    public function deleteActiviteEvent(AfterEntityDeletedEvent $event)
    {
        $this->setActivityParentPeriod($event);
    }

    public function updateActiviteEvent(AfterEntityUpdatedEvent $event)
    {
        $this->setActivityParentPeriod($event);
    }

    private function setActivityParentPeriod($event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Activite)) {
            return;
        }

        $activityParent = $entity->getParentId();
        if ($activityParent) {
            $oldestActivity = $this->activiteRepository->findOldestActivity($activityParent);
            $activityParent->setDateFin($oldestActivity->getDateFin());
            $this->manager->persist($activityParent);

            $earliestActivity = $this->activiteRepository->findEarliestActivity($activityParent);
            $activityParent->setDateDebut($earliestActivity->getDateDebut());
            $this->manager->persist($activityParent);

            $this->manager->flush();
        }
    }
}
