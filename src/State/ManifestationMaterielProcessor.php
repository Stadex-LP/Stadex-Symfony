<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Manifestation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ManifestationMaterielProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $manifestation = $this->entityManager->getRepository(Manifestation::class)->find($uriVariables['id']);

        if ($manifestation == null) {
            throw new HttpException(404, "Manifestation not found");
        }

        $data->setManifestation($manifestation);
        $data->setPrixUnitaireFact($data->getMateriel()->getPrixUnitaire());

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
