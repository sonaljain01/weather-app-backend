<?php

namespace App\Support\Fractal\Serializers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\SerializerAbstract;

class ArraySerializer extends SerializerAbstract
{
    /**
     * {@inheritDoc}
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function collection($resourceKey, array $data): array //@phpstan-ignore-line
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function item($resourceKey, array $data): array //@phpstan-ignore-line
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string>|null
     */
    public function null(): ?array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function includedData(ResourceInterface $resource, array $data): array
    {
        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @param  array<string, mixed>  $meta
     * @return array<string, array<string, mixed>>
     */
    public function meta(array $meta): array
    {
        if (empty($meta)) {
            return [];
        }

        return ['meta' => $meta];
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string, array<string, mixed>>
     */
    public function paginator(PaginatorInterface $paginator): array
    {
        $currentPage = $paginator->getCurrentPage();
        $lastPage = $paginator->getLastPage();

        $pagination = [
            'total' => $paginator->getTotal(),
            'count' => $paginator->getCount(),
            'per_page' => $paginator->getPerPage(),
            'current_page' => $currentPage,
            'total_pages' => $lastPage,
        ];

        $pagination['links'] = [];

        if ($currentPage > 1) {
            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        if (empty($pagination['links'])) {
            $pagination['links'] = (object) [];
        }

        return ['pagination' => $pagination];
    }

    /**
     * {@inheritDoc}
     *
     * @return array<string, array<string, mixed>>
     */
    public function cursor(CursorInterface $cursor): array
    {
        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev' => $cursor->getPrev(),
            'next' => $cursor->getNext(),
            'count' => $cursor->getCount(),
        ];

        return ['cursor' => $cursor];
    }
}
