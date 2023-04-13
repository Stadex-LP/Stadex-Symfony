<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CsvExportService
{
    private array $encoders;
    private array $normalizers;
    private SerializerInterface $serializer;

    public function __construct() {
        $this->encoders = [new CsvEncoder()];
        $this->normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }
    public function exportMaterielsToCsv(array $materiels): string
    {
        return $this->serializer->serialize($materiels, 'csv', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['manifestationMateriels']]);
    }

    public function exportTransportsToCsv(array $transports): string
    {
        return $this->serializer->serialize($transports, 'csv', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['manifestationTransports']]);
    }

    public function exportEquipementSportifsToCsv(array $equipementSportifs): string
    {
        return $this->serializer->serialize($equipementSportifs, 'csv', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['manifestationEquipementSportifs']]);
    }

    public function exportMainOeuvresToCsv(array $mainOeuvres): string
    {
        return $this->serializer->serialize($mainOeuvres, 'csv', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['manifestationMainOeuvres']]);
    }

    public function exportOrganisateursToCsv(array $organisateurs): string
    {
        return $this->serializer->serialize($organisateurs, 'csv', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['manifestations']]);
    }

    public function exportManifestationsToCsv(array $manifestations): string
    {
        return $this->serializer->serialize($manifestations, 'csv', [AbstractNormalizer::ATTRIBUTES => ['id', 'denomination', 'dateDebut', 'dateFin', 'lieu']]);
    }

}