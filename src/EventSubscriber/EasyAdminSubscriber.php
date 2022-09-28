<?php

namespace App\EventSubscriber;

use App\Entity\Activite;
use App\Entity\User;
use App\Repository\ActiviteRepository;
use App\Repository\ComposantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private ActiviteRepository $activiteRepository,
        private ComposantRepository $composantRepository,
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['createUserEvent'],
            AfterEntityPersistedEvent::class => ['createActiviteEvent'],
            AfterEntityUpdatedEvent::class => ['updateActiviteEvent'],
            AfterEntityDeletedEvent::class => ['deleteActiviteEvent'],
        ];
    }

    public function createUserEvent(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof User)) {
            return;
        }

        $password = $this->hasher->hashPassword($entity, 'passer');
        $entity->setPassword($password);
        $this->manager->persist($entity);
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

            $earliestActivity = $this->activiteRepository->findEarliestActivity($activityParent);
            $activityParent->setDateDebut($earliestActivity->getDateDebut());

            $avgAchevment = $this->activiteRepository->avgAchevment($activityParent);
            $activityParent->setNiveauAchevement($avgAchevment);

            // composant
            $composant = $activityParent->getComposant();
            $oldestParentActivity = $this->activiteRepository->findOldestParentActivity($composant);
            $composant->setDateFin($oldestParentActivity->getDateFin());

            $earliestParentActivity = $this->activiteRepository->findEarliestParentActivity($composant);
            $composant->setDateDebut($earliestParentActivity->getDateDebut());

            $avgAchevment = $this->activiteRepository->avgAchevmentComposant($composant);
            $composant->setNiveauAchevement($avgAchevment);


            $this->manager->persist($activityParent);
            $this->manager->persist($composant);
            $this->manager->flush();
        }
    }
}
