<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventNormalizer implements NormalizerInterface
{
    public function normalize($event, string $format = null, array $context = []): array
    {
        return [
            'id' => $event->getId(),
            'title' => $event->getTitle(),
            'start' => $event->getStartAt()->format('Y-m-d'),
            'end' => $event->getEndAt()?->format('Y-m-d'),
            'url' => 'evenement/'.($event->getSlug()),
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof \App\Entity\Event;
    }

}
