<?php


namespace OdooApiClient\Entities;


interface EntityInterface {

    public function create(array $data);//

    public function read(array $ids, array $fields): array;//

    public function update(int $id, array $data);

    public function delete(int $id): bool;//

    public function list(array $filter_data): array;

    public function listFields(): array;
}