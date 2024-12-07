<?php

namespace database\factories;

class UserFactory
{
    public static function create(): array
    {
        return [
            'first_name' => self::randomFirstName(),
            'last_name' => self::randomLastName(),
            'email' => self::randomEmail(),
            'mobile_number' => rand(1000000000, 9999999999),
            'address' => self::randomAddress(),
            'city' => self::randomCity(),
            'state' => self::randomState(),
            'zip' => rand(10000, 99999),
        ];
    }

    private static function randomFirstName(): string
    {
        $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Charlie'];

        return $firstNames[array_rand($firstNames)];
    }

    private static function randomLastName(): string
    {
        $lastNames = ['Smith', 'Doe', 'Johnson', 'Brown', 'Taylor'];

        return $lastNames[array_rand($lastNames)];
    }

    private static function randomEmail(): string
    {
        $domains = ['example.com', 'test.com', 'demo.com'];
        $username = strtolower(self::randomFirstName().self::randomLastName());

        return $username . '@' . $domains[array_rand($domains)];
    }

    private static function randomAddress(): string
    {
        $streetNames = ['Main St', 'Broadway', 'Elm St', 'Market St'];
        $streetNumber = rand(1, 9999);

        return $streetNumber . ' ' . $streetNames[array_rand($streetNames)];
    }

    private static function randomCity(): string
    {
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];

        return $cities[array_rand($cities)];
    }

    private static function randomState(): string
    {
        $states = ['NY', 'CA', 'TX', 'IL', 'AZ'];

        return $states[array_rand($states)];
    }
}