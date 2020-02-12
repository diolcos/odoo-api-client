<?php


namespace OdooApiClient\Entities;


interface EntityInterface {
    public function create(string $name): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function list(array $filter_data): array;
}